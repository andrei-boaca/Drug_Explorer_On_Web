const CHART_COLORS = [
  '#2563EB', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
  '#EC4899', '#0EA5E9', '#F97316', '#84CC16', '#14B8A6',
];

const COLUMNS = {
  confiscari: [
    { key: 'drog', label: 'Drog' },
    { key: 'grame', label: 'Grame', num: true },
    { key: 'comprimate', label: 'Comprimate', num: true },
    { key: 'doze', label: 'Doze', num: true },
    { key: 'mililitri', label: 'mL', num: true },
    { key: 'nr_capturi', label: 'Nr. capturi', num: true },
    { key: 'an', label: 'An' },
  ],
  condamnari: [
    { key: 'numar', label: 'Nr. condamnati', num: true },
    { key: 'sex', label: 'Sex', badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'varsta_grup', label: 'Grup varsta', badge: { Minor: 'badge-minor', Major: 'badge-major' } },
    { key: 'an', label: 'An' },
  ],
  urgente: [
    { key: 'categorie', label: 'Categorie drog' },
    { key: 'sex', label: 'Sex', badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'nr_pacienti', label: 'Nr. pacienti', num: true },
    { key: 'an', label: 'An' },
  ],
  tratament: [
    { key: 'categorie', label: 'Categorie drog' },
    { key: 'regim', label: 'Regim' },
    { key: 'nr_pacienti', label: 'Nr. pacienti', num: true },
    { key: 'an', label: 'An' },
  ],
  actiuni: [
    { key: 'proiect', label: 'Proiect' },
    { key: 'nr_beneficiari', label: 'Nr. beneficiari', num: true },
    { key: 'an', label: 'An' },
  ],
  boli: [
    { key: 'boala', label: 'Boala' },
    { key: 'sex', label: 'Sex', badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'nr_testati', label: 'Testati', num: true },
    { key: 'nr_pozitivi', label: 'Pozitivi', num: true },
    { key: 'rata_pozitivi', label: 'Rata (%)', num: true },
  ],
};

const CHART_MAP = {
  confiscari: {
    bar: { labelKey: 'drog', valueKey: 'grame', label: 'Grame confiscate per drog', horiz: true },
    pie: { labelKey: 'drog', valueKey: 'nr_capturi', label: 'Capturi per tip drog' },
  },
  condamnari: {
    bar: { labelKey: 'varsta_grup', valueKey: 'numar', label: 'Condamnari per grup varsta', horiz: false },
    pie: { labelKey: 'sex', valueKey: 'numar', label: 'Distributie pe sex' },
  },
  urgente: {
    bar: { labelKey: 'categorie', valueKey: 'nr_pacienti', label: 'Pacienti urgente per categorie', horiz: true },
    pie: { labelKey: 'categorie', valueKey: 'nr_pacienti', label: 'Distributie categorii drog' },
  },
  tratament: {
    bar: { labelKey: 'categorie', valueKey: 'nr_pacienti', label: 'Pacienti tratament per categorie', horiz: true },
    pie: { labelKey: 'regim', valueKey: 'nr_pacienti', label: 'Distributie pe regim tratament' },
  },
  actiuni: {
    bar: { labelKey: 'proiect', valueKey: 'nr_beneficiari', label: 'Beneficiari per proiect', horiz: true },
    pie: { labelKey: 'proiect', valueKey: 'nr_beneficiari', label: 'Distributie beneficiari' },
  },
  boli: {
    bar: {
      multi: true,
      labelKey: 'boala',
      datasets: [
        { key: 'nr_testati', label: 'Testati', color: '#2563EB' },
        { key: 'nr_pozitivi', label: 'Pozitivi', color: '#EF4444' },
      ],
      label: 'Testati vs Pozitivi per boala',
      horiz: false,
    },
    pie: { labelKey: 'boala', valueKey: 'nr_pozitivi', label: 'Cazuri pozitive per boala' },
  },
};

const sectionData = {};
const currentView = {};
const chartInstances = {};
const sortState = {};
const visitedTabs = new Set();

function escHtml(v) {
  return String(v ?? '\u2014')
    .replace(/&/g, '&amp;').replace(/</g, '&lt;')
    .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function fmtNum(v) {
  if (v == null || v === '' || v === '\u2014') return '\u2014';
  const n = parseFloat(v);
  return isNaN(n) ? escHtml(v) : n.toLocaleString('ro-RO', { maximumFractionDigits: 2 });
}

function getFormParams(form) {
  const p = new URLSearchParams();
  form.querySelectorAll('input, select').forEach(el => {
    if (el.name && el.value.trim()) p.set(el.name, el.value.trim());
  });
  return p;
}

function aggregate(rows, labelKey, valueKey) {
  const map = {};
  rows.forEach(r => {
    const lbl = String(r[labelKey] ?? 'N/A');
    map[lbl] = (map[lbl] || 0) + (parseFloat(r[valueKey]) || 0);
  });
  const labels = Object.keys(map);
  return { labels, values: labels.map(l => map[l]) };
}

function renderTable(section, rows) {
  if (!rows || !rows.length) {
    return '<div class="empty-state"><p>Niciun rezultat gasit.</p></div>';
  }
  const cols = COLUMNS[section] || [];
  const { col: sCol, dir: sDir } = sortState[section] || {};

  let sorted = [...rows];
  if (sCol) {
    sorted.sort((a, b) => {
      const va = a[sCol], vb = b[sCol];
      const na = parseFloat(va), nb = parseFloat(vb);
      const cmp = !isNaN(na) && !isNaN(nb) ? na - nb : String(va ?? '').localeCompare(String(vb ?? ''), 'ro');
      return sDir === 'asc' ? cmp : -cmp;
    });
  }

  const ths = cols.map(c => {
    const active = c.key === sCol;
    const arrow  = active ? (sDir === 'asc' ? ' \u2191' : ' \u2193') : '';
    return `<th class="sortable${active ? ' sorted' : ''}" data-col="${c.key}" data-section="${section}">${c.label}${arrow}</th>`;
  }).join('');

  const trs = sorted.map((row, i) => {
    const tds = cols.map(c => {
      const val = row[c.key];
      if (c.badge && val != null && c.badge[val]) {
        return `<td><span class="badge ${c.badge[val]}">${escHtml(val)}</span></td>`;
      }
      if (c.num) return `<td class="num">${fmtNum(val)}</td>`;
      return `<td>${escHtml(val)}</td>`;
    }).join('');
    return `<tr class="${i % 2 === 0 ? 'row-even' : 'row-odd'}">${tds}</tr>`;
  }).join('');

  //trs += `<tr><td colspan="${cols.length}" class="table-footer">${printedEntries} ${printedEntries === 1 ? 'intrare' : 'intrari'}</td></tr>`;

  return `<div class="table-wrap"><table><thead><tr>${ths}</tr></thead><tbody>${trs}</tbody></table></div>`;
}

const DRILLABLE_SECTIONS = ['confiscari', 'urgente', 'tratament'];

function isDrillable(section, chartType) {
  if (!DRILLABLE_SECTIONS.includes(section)) return false;
  if (section === 'tratament' && chartType === 'pie') return false; // pie uses 'regim', not drug
  return true;
}

function openDrugModal(section, label) {
  const modal = document.getElementById('drug-modal');
  const title = document.getElementById('drug-modal-title');
  const subtitle = document.getElementById('drug-modal-subtitle');
  const body = document.getElementById('drug-modal-body');
  if (!modal) return;

  const sectionLabels = { confiscari: 'Confiscari', urgente: 'Urgente medicale', tratament: 'Tratament' };
  subtitle.textContent = sectionLabels[section] || section;
  title.textContent = label;
  body.innerHTML = '<div class="loading-state"><div class="spinner"></div><span>Se incarca informatiile...</span></div>';
  modal.classList.add('open');
  document.body.style.overflow = 'hidden';

  fetch('api/router.php?section=drug-detail&source=' + encodeURIComponent(section) + '&label=' + encodeURIComponent(label))
    .then(r => r.json())
    .then(json => {
      if (json.error) {
        body.innerHTML = '<p class="error-msg">' + escHtml(json.error) + '</p>';
        return;
      }
      body.innerHTML = renderDrugDetail(json.data);
    })
    .catch(() => {
      body.innerHTML = '<p class="error-msg">Eroare la incarcarea informatiilor.</p>';
    });
}

function closeDrugModal() {
  const modal = document.getElementById('drug-modal');
  if (modal) modal.classList.remove('open');
  document.body.style.overflow = '';
}

function renderDrugDetail(data) {
  if (!data) return '<p>Nu exista date disponibile.</p>';
  let html = '';

  if (data.type === 'confiscari') {
    const s = data.summary || {};
    const stats = [
      ['Grame totale',  s.total_grame],
      ['Nr. capturi',   s.total_capturi],
      ['Comprimate',    s.total_comprimate],
      ['Doze',          s.total_doze],
      ['Mililitri',     s.total_mililitri],
    ].filter(([, v]) => v != null && v !== '' && parseFloat(v) > 0);

    html += '<div class="detail-section">';
    html += '<div class="detail-section-title">Statistici confiscari 2022</div>';
    html += '<div class="stat-grid">';
    stats.forEach(([lbl, val]) => { html += statCard(lbl, fmtNum(val)); });
    html += '</div></div>';

    if (data.category) {
      html += '<div class="detail-category-tag">Categorie drog: <strong>' + escHtml(data.category) + '</strong></div>';
    }

    const urgenteHasData = data.urgente && Object.values(data.urgente).some(a => a.length > 0);
    if (urgenteHasData) {
      html += renderBreakdowns('Urgente medicale (categoria ' + escHtml(data.category || '') + ')', data.urgente, {
        sex: 'Distributie pe sex', varsta: 'Grupe de varsta', cale: 'Cale de administrare', diagnostic: 'Diagnostic',
      });
    }

    const tratamentHasData = data.tratament && Object.values(data.tratament).some(a => a.length > 0);
    if (tratamentHasData) {
      html += renderBreakdowns('Tratament (categoria ' + escHtml(data.category || '') + ')', data.tratament, {
        regim: 'Regim tratament', sex: 'Distributie pe sex', varsta: 'Grupe de varsta', ocupatie: 'Ocupatie pacienti',
      });
    }

    if (!urgenteHasData && !tratamentHasData && !data.category) {
      html += '<p class="detail-note">Nu exista date suplimentare disponibile pentru acest drog.</p>';
    }
  }

  if (data.type === 'urgente') {
    html += renderBreakdowns('Detalii urgente medicale', data.breakdowns, {
      sex: 'Distributie pe sex', varsta: 'Grupe de varsta', cale: 'Cale de administrare', diagnostic: 'Diagnostic',
    });
  }

  if (data.type === 'tratament') {
    html += renderBreakdowns('Detalii tratament', data.breakdowns, {
      regim: 'Regim tratament', sex: 'Distributie pe sex', varsta: 'Grupe de varsta', ocupatie: 'Ocupatie pacienti',
    });
  }

  return html || '<p class="detail-note">Nu exista date suplimentare disponibile.</p>';
}

function statCard(label, value) {
  return '<div class="stat-card"><div class="stat-value">' + value + '</div><div class="stat-label">' + escHtml(label) + '</div></div>';
}

function renderBreakdowns(title, breakdowns, labels) {
  if (!breakdowns) return '';
  const entries = Object.entries(labels).filter(([key]) => (breakdowns[key] || []).length > 0);
  if (!entries.length) return '';

  let html = '<div class="detail-section"><div class="detail-section-title">' + escHtml(title) + '</div><div class="breakdown-grid">';
  entries.forEach(([key, label]) => {
    const rows = breakdowns[key];
    const total = rows.reduce((s, r) => s + (parseFloat(r.valoare) || 0), 0);
    html += '<div class="breakdown-block"><div class="breakdown-block-title">' + escHtml(label) + '</div>';
    html += '<table class="breakdown-table"><tbody>';
    rows.forEach(r => {
      const pct = total > 0 ? Math.round((parseFloat(r.valoare) / total) * 100) : 0;
      html += '<tr><td>' + escHtml(r.label) + '</td><td class="num">' + fmtNum(r.valoare) + '</td>';
      html += '<td><div class="bar-mini"><div style="width:' + pct + '%"></div></div></td></tr>';
    });
    html += '</tbody></table></div>';
  });
  html += '</div></div>';
  return html;
}

document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('drug-modal-close')?.addEventListener('click', closeDrugModal);
  document.getElementById('drug-modal-overlay')?.addEventListener('click', closeDrugModal);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrugModal(); });
});

const FONT_C = "11px 'Inter', system-ui, sans-serif";
const GRID_C = '#E2E8F0';
const TICK_C = '#64748B';

function niceMax(max) {
  if (max <= 0) return 10;
  const exp = Math.pow(10, Math.floor(Math.log10(max)));
  const frac = max / exp;
  const nice = frac <= 1 ? 1 : frac <= 2 ? 2 : frac <= 5 ? 5 : 10;
  return nice * exp;
}

function fitText(ctx, text, maxW) {
  if (ctx.measureText(text).width <= maxW) return text;
  let t = text;
  while (t.length > 1 && ctx.measureText(t + '\u2026').width > maxW) t = t.slice(0, -1);
  return t + '\u2026';
}

function hexAlpha(hex, a) {
  const n = parseInt(hex.slice(1, 7), 16);
  return `rgba(${(n >> 16) & 255},${(n >> 8) & 255},${n & 255},${a})`;
}

function setupCanvas(canvas) {
  const dpr = window.devicePixelRatio || 1;
  const rect = canvas.getBoundingClientRect();
  canvas.width = Math.round(rect.width * dpr);
  canvas.height = Math.round(rect.height * dpr);
  const ctx = canvas.getContext('2d');
  ctx.scale(dpr, dpr);
  return { ctx, w: rect.width, h: rect.height };
}


function createVerticalBar(canvas, { labels, datasets, drillable, onBarClick }) {
  let hovered = -1;
  let hitAreas = [];
  const isMulti = datasets.length > 1;

  function draw() {
    const { ctx, w, h } = setupCanvas(canvas);
    const PAD = { t: 20, r: 20, b: isMulti ? 70 : 55, l: 60 };
    const cw = w - PAD.l - PAD.r;
    const ch = h - PAD.t - PAD.b;
    const STEPS = 5;
    const maxVal = niceMax(Math.max(...datasets.flatMap(d => d.data), 1));

    ctx.clearRect(0, 0, w, h);
    ctx.font = FONT_C;

    for (let i = 0; i <= STEPS; i++) {
      const val = maxVal * (STEPS - i) / STEPS;
      const y = PAD.t + ch * i / STEPS;
      ctx.strokeStyle = GRID_C; ctx.lineWidth = 1;
      ctx.beginPath(); ctx.moveTo(PAD.l, y); ctx.lineTo(PAD.l + cw, y); ctx.stroke();
      ctx.fillStyle = TICK_C; ctx.textAlign = 'right'; ctx.textBaseline = 'middle';
      ctx.fillText(val.toLocaleString('ro-RO', { maximumFractionDigits: 0 }), PAD.l - 5, y);
    }

    hitAreas = [];
    const groupW = cw / labels.length;
    const bGap = 4;
    const bPad = Math.max(3, groupW * (isMulti ? 0.08 : 0.15));
    const bW = (groupW - bPad * 2 - bGap * (datasets.length - 1)) / datasets.length;

    datasets.forEach((ds, di) => {
      ds.data.forEach((val, i) => {
        const barH = val > 0 ? (val / maxVal) * ch : 0;
        const x = PAD.l + i * groupW + bPad + di * (bW + bGap);
        const y = PAD.t + ch - barH;
        const col = Array.isArray(ds.colors) ? ds.colors[i % ds.colors.length] : ds.color;
        const isHov = drillable && !isMulti && hovered === i;
        ctx.fillStyle = hexAlpha(col, isHov ? 1 : 0.8);
        ctx.strokeStyle = col; ctx.lineWidth = 1.5;
        ctx.beginPath();
        if (ctx.roundRect) ctx.roundRect(x, y, bW, barH, [3, 3, 0, 0]);
        else ctx.rect(x, y, bW, barH);
        ctx.fill(); ctx.stroke();
        if (!isMulti) hitAreas.push({ i, x, y: PAD.t, w: bW, h: ch });
      });
    });

    ctx.fillStyle = TICK_C; ctx.textAlign = 'center'; ctx.textBaseline = 'top';
    const maxLblW = groupW - 4;
    labels.forEach((lbl, i) => {
      ctx.fillText(fitText(ctx, String(lbl), maxLblW), PAD.l + i * groupW + groupW / 2, PAD.t + ch + 8);
    });

    if (isMulti) {
      let lx = PAD.l;
      ctx.textBaseline = 'middle';
      datasets.forEach(ds => {
        ctx.fillStyle = ds.color;
        ctx.fillRect(lx, h - 18, 12, 12);
        ctx.fillStyle = TICK_C; ctx.textAlign = 'left';
        ctx.fillText(ds.label, lx + 16, h - 12);
        lx += ctx.measureText(ds.label).width + 36;
      });
    }
  }

  function barAt(e) {
    const r = canvas.getBoundingClientRect();
    const mx = e.clientX - r.left, my = e.clientY - r.top;
    return hitAreas.findIndex(a => mx >= a.x && mx <= a.x + a.w && my >= a.y && my <= a.y + a.h);
  }
  function onMove(e) {
    const idx = barAt(e);
    if (idx !== hovered) {
      hovered = idx;
      canvas.style.cursor = (idx >= 0 && drillable) ? 'pointer' : 'default';
      draw();
    }
  }
  function onClick(e) {
    const idx = barAt(e);
    if (idx >= 0 && onBarClick) onBarClick(labels[idx]);
  }

  draw();
  canvas.addEventListener('mousemove', onMove);
  canvas.addEventListener('click', onClick);
  return () => { canvas.removeEventListener('mousemove', onMove); canvas.removeEventListener('click', onClick); };
}


function createHorizontalBar(canvas, { labels, values, colors, drillable, onBarClick }) {
  let hovered = -1;
  let hitAreas = [];

  function draw() {
    const { ctx, w, h } = setupCanvas(canvas);
    const LBL_W = Math.min(160, w * 0.28);
    const PAD = { t: 10, r: 70, b: 24, l: LBL_W + 10 };
    const cw = w - PAD.l - PAD.r;
    const ch = h - PAD.t - PAD.b;
    const STEPS = 4;
    const maxVal = niceMax(Math.max(...values, 1));

    ctx.clearRect(0, 0, w, h);
    ctx.font = FONT_C;

    for (let i = 0; i <= STEPS; i++) {
      const val = maxVal * i / STEPS;
      const x = PAD.l + cw * i / STEPS;
      ctx.strokeStyle = GRID_C; ctx.lineWidth = 1;
      ctx.beginPath(); ctx.moveTo(x, PAD.t); ctx.lineTo(x, PAD.t + ch); ctx.stroke();
      ctx.fillStyle = TICK_C; ctx.textAlign = 'center'; ctx.textBaseline = 'top';
      ctx.fillText(val.toLocaleString('ro-RO', { maximumFractionDigits: 0 }), x, PAD.t + ch + 4);
    }

    hitAreas = [];
    const rowH = ch / labels.length;
    const bPad = Math.max(2, rowH * 0.15);
    const bH = rowH - bPad * 2;

    labels.forEach((lbl, i) => {
      const val = values[i] || 0;
      const barW = (val / maxVal) * cw;
      const x = PAD.l;
      const y = PAD.t + i * rowH + bPad;
      const col = colors[i % colors.length];
      const isHov = drillable && hovered === i;

      ctx.fillStyle = TICK_C; ctx.textAlign = 'right'; ctx.textBaseline = 'middle';
      ctx.fillText(fitText(ctx, String(lbl), LBL_W - 6), PAD.l - 8, y + bH / 2);

      ctx.fillStyle = hexAlpha(col, isHov ? 1 : 0.8);
      ctx.strokeStyle = col; ctx.lineWidth = 1.5;
      ctx.beginPath();
      if (ctx.roundRect) ctx.roundRect(x, y, barW, bH, [0, 3, 3, 0]);
      else ctx.rect(x, y, barW, bH);
      ctx.fill(); ctx.stroke();

      ctx.fillStyle = TICK_C; ctx.textAlign = 'left'; ctx.textBaseline = 'middle';
      ctx.fillText(val.toLocaleString('ro-RO', { maximumFractionDigits: 1 }), x + barW + 5, y + bH / 2);

      hitAreas.push({ i, x, y, w: cw, h: bH });
    });
  }

  function barAt(e) {
    const r = canvas.getBoundingClientRect();
    const mx = e.clientX - r.left, my = e.clientY - r.top;
    return hitAreas.findIndex(a => mx >= a.x && mx <= a.x + a.w && my >= a.y && my <= a.y + a.h);
  }
  function onMove(e) {
    const idx = barAt(e);
    if (idx !== hovered) {
      hovered = idx; 
      canvas.style.cursor = (idx >= 0 && drillable) ? 'pointer' : 'default';
      draw();
    }
  }
  function onClick(e) {
    const idx = barAt(e);
    if (idx >= 0 && onBarClick) onBarClick(labels[idx]);
  }

  draw();
  canvas.addEventListener('mousemove', onMove);
  canvas.addEventListener('click', onClick);
  return () => { canvas.removeEventListener('mousemove', onMove); canvas.removeEventListener('click', onClick); };
}

function createDoughnut(canvas, { labels, values, colors, drillable, onSliceClick }) {
  let hovered = -1;
  let slices = [];

  function draw() {
    const { ctx, w, h } = setupCanvas(canvas);
    ctx.clearRect(0, 0, w, h);
    ctx.font = FONT_C;

    const total = values.reduce((a, b) => a + b, 0);
    if (total <= 0) return;

    const LEGEND_W = Math.min(200, w * 0.36);
    const chartW = w - LEGEND_W;
    const cx = chartW / 2, cy = h / 2;
    const r = Math.min(cx, cy) * 0.78;
    const ir = r * 0.52;

    slices = [];
    let angle = -Math.PI / 2;
    values.forEach((val, i) => {
      const arc = (val / total) * Math.PI * 2;
      const isHov = drillable && hovered === i;
      const col = colors[i % colors.length];
      const rr = isHov ? r * 1.04 : r;
      ctx.beginPath();
      ctx.moveTo(cx, cy);
      ctx.arc(cx, cy, rr, angle, angle + arc);
      ctx.closePath();
      ctx.fillStyle = hexAlpha(col, isHov ? 1 : 0.82);
      ctx.strokeStyle = '#fff'; ctx.lineWidth = 2;
      ctx.fill(); ctx.stroke();
      slices.push({ i, startAngle: angle, endAngle: angle + arc, cx, cy, r: rr });
      angle += arc;
    });

    ctx.beginPath(); ctx.arc(cx, cy, ir, 0, Math.PI * 2);
    ctx.fillStyle = '#fff'; ctx.fill();

    ctx.textAlign = 'center'; ctx.textBaseline = 'middle';
    if (hovered >= 0) {
      const pct = ((values[hovered] / total) * 100).toFixed(1);
      ctx.fillStyle = '#1E293B'; ctx.font = "bold 14px 'Inter', system-ui, sans-serif";
      ctx.fillText(pct + '%', cx, cy - 8);
      ctx.font = FONT_C; ctx.fillStyle = TICK_C;
      ctx.fillText(fitText(ctx, labels[hovered], ir * 1.6), cx, cy + 10);
    } else {
      ctx.fillStyle = TICK_C;
      ctx.fillText('Total: ' + total.toLocaleString('ro-RO', { maximumFractionDigits: 0 }), cx, cy);
    }

    const lineH = 22;
    const startY = (h - labels.length * lineH) / 2;
    ctx.textBaseline = 'middle';
    labels.forEach((lbl, i) => {
      const y = startY + i * lineH + lineH / 2;
      const col = colors[i % colors.length];
      const pct = ((values[i] / total) * 100).toFixed(1);
      ctx.fillStyle = hexAlpha(col, hovered === i ? 1 : 0.82);
      ctx.beginPath(); ctx.arc(w - LEGEND_W + 10, y, 5, 0, Math.PI * 2); ctx.fill();
      ctx.fillStyle = TICK_C; ctx.textAlign = 'left';
      ctx.fillText(fitText(ctx, `${lbl} (${pct}%)`, LEGEND_W - 28), w - LEGEND_W + 22, y);
    });
  }

  function sliceAt(e) {
    const r = canvas.getBoundingClientRect();
    const mx = e.clientX - r.left, my = e.clientY - r.top;
    for (const s of slices) {
      const dx = mx - s.cx, dy = my - s.cy;
      if (Math.sqrt(dx * dx + dy * dy) > s.r * 1.1) continue;
      let a = Math.atan2(dy, dx);
      if (slices.length && a < slices[0].startAngle) a += Math.PI * 2;
      if (a >= s.startAngle && a < s.endAngle) return s.i;
    }
    return -1;
  }
  function onMove(e) {
    const idx = sliceAt(e);
    if (idx !== hovered) {
      hovered = idx;
      canvas.style.cursor = (idx >= 0 && drillable) ? 'pointer' : 'default';
      draw();
    }
  }
  function onClick(e) {
    const idx = sliceAt(e);
    if (idx >= 0 && onSliceClick) onSliceClick(labels[idx]);
  }

  draw();
  canvas.addEventListener('mousemove', onMove);
  canvas.addEventListener('click', onClick);
  return () => { canvas.removeEventListener('mousemove', onMove); canvas.removeEventListener('click', onClick); };
}

function renderChart(section, rows, chartType) {
  const container = document.getElementById('result-' + section);
  if (!container) return;

  if (chartInstances[section]) {
    chartInstances[section]();
    chartInstances[section] = null;
  }

  if (!rows || !rows.length) {
    container.innerHTML = '<div class="empty-state"><p>Niciun rezultat de afișat.</p></div>';
    return;
  }

  const cfg = CHART_MAP[section]?.[chartType];
  if (!cfg) return;

  const drillable = isDrillable(section, chartType);
  const hint = drillable
    ? '<p class="chart-hint"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/></svg> Apasă pe un element din grafic pentru mai multe detalii</p>'
    : '';
  container.innerHTML = `<div class="chart-container"><canvas id="chart-${section}" style="width:100%;height:100%;display:block;"></canvas></div>${hint}`;
  const cvs = document.getElementById('chart-' + section);

  if (chartType === 'pie') {
    const { labels, values } = aggregate(rows, cfg.labelKey, cfg.valueKey);
    const colors = labels.map((_, i) => CHART_COLORS[i % CHART_COLORS.length]);
    chartInstances[section] = createDoughnut(cvs, {
      labels, values, colors, drillable,
      onSliceClick: drillable ? lbl => openDrugModal(section, lbl) : null,
    });
    return;
  }

  if (cfg.multi) {
    const labels = [...new Set(rows.map(r => String(r[cfg.labelKey] ?? '')))];
    const datasets = cfg.datasets.map(ds => ({
      label: ds.label, color: ds.color,
      data:  labels.map(lbl =>
        rows.filter(r => String(r[cfg.labelKey]) === lbl)
            .reduce((s, r) => s + (parseFloat(r[ds.key]) || 0), 0)
      ),
    }));
    chartInstances[section] = createVerticalBar(cvs, { labels, datasets, drillable: false, onBarClick: null });
    return;
  }

  const { labels, values } = aggregate(rows, cfg.labelKey, cfg.valueKey);
  const colors = labels.map((_, i) => CHART_COLORS[i % CHART_COLORS.length]);
  if (cfg.horiz) {
    chartInstances[section] = createHorizontalBar(cvs, {
      labels, values, colors, drillable,
      onBarClick: drillable ? lbl => openDrugModal(section, lbl) : null,
    });
  } else {
    chartInstances[section] = createVerticalBar(cvs, {
      labels, datasets: [{ label: cfg.label, color: colors[0], colors, data: values }],
      drillable,
      onBarClick: drillable ? lbl => openDrugModal(section, lbl) : null,
    });
  }
}

function renderData(section, rows) {
  const view = currentView[section] || 'table';

  const headerEl = document.getElementById('header-' + section);
  const countEl = document.getElementById('count-' + section);
  if (headerEl) headerEl.style.display = '';
  if (countEl) {
    const n = rows ? rows.length : 0;
    countEl.textContent = n + ' rezultat' + (n !== 1 ? 'e' : '') + ' gasite';
  }

  if (view === 'table') {
    const resultEl = document.getElementById('result-' + section);
    if (resultEl) {
      resultEl.innerHTML = renderTable(section, rows);
      resultEl.querySelectorAll('th.sortable').forEach(th => {
        th.addEventListener('click', () => {
          const col = th.dataset.col;
          const sec = th.dataset.section;
          const cur = sortState[sec] || {};
          sortState[sec] = { col, dir: cur.col === col && cur.dir === 'asc' ? 'desc' : 'asc' };
          renderData(sec, sectionData[sec]);
        });
      });
    }
  } else {
    renderChart(section, rows, view);
  }
}

document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    btn.classList.add('active');
    const section = btn.dataset.section;
    document.getElementById('sec-' + section)?.classList.add('active');
    if (!visitedTabs.has(section)) {
      visitedTabs.add(section);
      const form = document.querySelector('#sec-' + section + ' .ajax-form');
      if (form) form.dispatchEvent(new Event('submit'));
    }
  });
});

document.querySelectorAll('.view-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const section = btn.dataset.section;
    const view = btn.dataset.view;
    currentView[section] = view;
    document.querySelectorAll('#toggle-' + section + ' .view-btn').forEach(b => {
      b.classList.toggle('active', b.dataset.view === view);
    });
    if (sectionData[section]) renderData(section, sectionData[section]);
  });
});

fetch('api/router.php?section=filters')
  .then(r => r.json())
  .then(data => {
    document.querySelectorAll('select[name="drog_id"]').forEach(sel => {
      (data.droguri || []).forEach(item => sel.appendChild(new Option(item.label, item.id)));
    });
    document.querySelectorAll('select[name="categorie_id"]').forEach(sel => {
      (data.categorii || []).forEach(item => sel.appendChild(new Option(item.label, item.id)));
    });
    document.querySelectorAll('select[name="boala_id"]').forEach(sel => {
      (data.boli || []).forEach(item => sel.appendChild(new Option(item.label, item.id)));
    });
    if (!visitedTabs.has('confiscari')) {
      visitedTabs.add('confiscari');
      const form = document.querySelector('#sec-confiscari .ajax-form');
      if (form) form.dispatchEvent(new Event('submit'));
    }
  })
  .catch(() => console.error('Filtrele nu s-au putut incarca.'));

document.querySelectorAll('.ajax-form').forEach(form => {
  form.addEventListener('submit', async e => {
    e.preventDefault();
    const section = form.dataset.section;
    const resultEl = document.getElementById('result-' + section);
    const params = getFormParams(form);
    params.set('section', section);
    const btn = form.querySelector('button[type="submit"]');

    resultEl.innerHTML = '<div class="loading-state"><div class="spinner"></div><span>Se incarca datele...</span></div>';
    if (btn) btn.disabled = true;

    try {
      const res = await fetch('api/router.php?' + params.toString());
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const json = await res.json();
      if (json.error) {
        resultEl.innerHTML = '<div class="empty-state"><p class="error-msg">Eroare: ' + escHtml(json.error) + '</p></div>';
      } else {
        sectionData[section] = json.data || [];
        if (!currentView[section]) currentView[section] = 'table';
        renderData(section, sectionData[section]);
      }
    } catch (err) {
      resultEl.innerHTML = '<div class="empty-state"><p class="error-msg">Eroare de retea. Verifica serverul si incearca din nou.</p></div>';
      console.error(err);
    } finally {
      if (btn) btn.disabled = false;
    }
  });
});

document.querySelectorAll('.btn-export').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const section = btn.dataset.section;
    const format = btn.dataset.format;
    const form = document.querySelector('#sec-' + section + ' .ajax-form');
    const params = getFormParams(form);
    params.set('section', section);
    params.set('format', format);
    window.location.href = 'api/router.php?' + params.toString();
  });
});
