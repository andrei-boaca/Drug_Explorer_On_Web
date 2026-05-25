/* ================================================================
   app.js – DrugExplorer · AJAX + Chart.js visualizare
   ================================================================ */

// ── Chart colours (10 vivid, high-contrast on white) ─────────────
const CHART_COLORS = [
  '#2563EB', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
  '#EC4899', '#0EA5E9', '#F97316', '#84CC16', '#14B8A6',
];

// ── Column definitions ────────────────────────────────────────────
const COLUMNS = {
  confiscari: [
    { key: 'drog',       label: 'Drog' },
    { key: 'grame',      label: 'Grame',       num: true },
    { key: 'comprimate', label: 'Comprimate',  num: true },
    { key: 'doze',       label: 'Doze',        num: true },
    { key: 'mililitri',  label: 'mL',          num: true },
    { key: 'nr_capturi', label: 'Nr. capturi', num: true },
    { key: 'an',         label: 'An' },
  ],
  condamnari: [
    { key: 'numar',       label: 'Nr. condamnati', num: true },
    { key: 'sex',         label: 'Sex',            badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'varsta_grup', label: 'Grup varsta',    badge: { Minor: 'badge-minor', Major: 'badge-major' } },
    { key: 'an',          label: 'An' },
  ],
  urgente: [
    { key: 'categorie',   label: 'Categorie drog' },
    { key: 'sex',         label: 'Sex',            badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'nr_pacienti', label: 'Nr. pacienti',   num: true },
    { key: 'an',          label: 'An' },
  ],
  tratament: [
    { key: 'categorie',   label: 'Categorie drog' },
    { key: 'regim',       label: 'Regim' },
    { key: 'nr_pacienti', label: 'Nr. pacienti', num: true },
    { key: 'an',          label: 'An' },
  ],
  actiuni: [
    { key: 'proiect',        label: 'Proiect' },
    { key: 'nr_beneficiari', label: 'Nr. beneficiari', num: true },
    { key: 'an',             label: 'An' },
  ],
  boli: [
    { key: 'boala',         label: 'Boala' },
    { key: 'sex',           label: 'Sex',       badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'nr_testati',    label: 'Testati',   num: true },
    { key: 'nr_pozitivi',   label: 'Pozitivi',  num: true },
    { key: 'rata_pozitivi', label: 'Rata (%)',  num: true },
  ],
};

// ── Chart mapping per section ─────────────────────────────────────
const CHART_MAP = {
  confiscari:  {
    bar: { labelKey: 'drog',       valueKey: 'grame',          label: 'Grame confiscate per drog',        horiz: true  },
    pie: { labelKey: 'drog',       valueKey: 'nr_capturi',     label: 'Capturi per tip drog'               },
  },
  condamnari:  {
    bar: { labelKey: 'varsta_grup',valueKey: 'numar',          label: 'Condamnari per grup varsta',       horiz: false },
    pie: { labelKey: 'sex',        valueKey: 'numar',          label: 'Distributie pe sex'                 },
  },
  urgente:     {
    bar: { labelKey: 'categorie',  valueKey: 'nr_pacienti',    label: 'Pacienti urgente per categorie',   horiz: true  },
    pie: { labelKey: 'categorie',  valueKey: 'nr_pacienti',    label: 'Distributie categorii drog'         },
  },
  tratament:   {
    bar: { labelKey: 'categorie',  valueKey: 'nr_pacienti',    label: 'Pacienti tratament per categorie', horiz: true  },
    pie: { labelKey: 'regim',      valueKey: 'nr_pacienti',    label: 'Distributie pe regim tratament'     },
  },
  actiuni:     {
    bar: { labelKey: 'proiect',    valueKey: 'nr_beneficiari', label: 'Beneficiari per proiect',          horiz: true  },
    pie: { labelKey: 'proiect',    valueKey: 'nr_beneficiari', label: 'Distributie beneficiari'            },
  },
  boli: {
    bar: {
      multi: true,
      labelKey: 'boala',
      datasets: [
        { key: 'nr_testati',  label: 'Testati',  color: '#2563EB' },
        { key: 'nr_pozitivi', label: 'Pozitivi', color: '#EF4444' },
      ],
      label: 'Testati vs Pozitivi per boala',
      horiz: false,
    },
    pie: { labelKey: 'boala', valueKey: 'nr_pozitivi', label: 'Cazuri pozitive per boala' },
  },
};

// ── State ─────────────────────────────────────────────────────────
const sectionData    = {};   // rows cache per section
const currentView    = {};   // 'table' | 'bar' | 'pie'
const chartInstances = {};   // Chart.js instances
const sortState      = {};   // { col, dir } per section
const visitedTabs    = new Set();

// ── Helpers ───────────────────────────────────────────────────────
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

// ── Table rendering ───────────────────────────────────────────────
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

  return `<div class="table-wrap"><table><thead><tr>${ths}</tr></thead><tbody>${trs}</tbody></table></div>`;
}

// ── Drug detail modal ─────────────────────────────────────────────
const DRILLABLE_SECTIONS = ['confiscari', 'urgente', 'tratament'];

function isDrillable(section, chartType) {
  if (!DRILLABLE_SECTIONS.includes(section)) return false;
  if (section === 'tratament' && chartType === 'pie') return false; // pie uses 'regim', not drug
  return true;
}

function openDrugModal(section, label) {
  const modal    = document.getElementById('drug-modal');
  const title    = document.getElementById('drug-modal-title');
  const subtitle = document.getElementById('drug-modal-subtitle');
  const body     = document.getElementById('drug-modal-body');
  if (!modal) return;

  const sectionLabels = { confiscari: 'Confiscari', urgente: 'Urgente medicale', tratament: 'Tratament' };
  subtitle.textContent = sectionLabels[section] || section;
  title.textContent    = label;
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

// ── Modal close bindings (set up after DOM ready) ─────────────────
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('drug-modal-close')?.addEventListener('click', closeDrugModal);
  document.getElementById('drug-modal-overlay')?.addEventListener('click', closeDrugModal);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrugModal(); });
});

// ── Chart config builder ──────────────────────────────────────────
function buildChartConfig(section, rows, chartType) {
  const cfg = CHART_MAP[section]?.[chartType];
  if (!cfg || !rows.length) return null;

  const fontDef = { family: 'Inter, system-ui, sans-serif', size: 11 };
  const gridColor = '#E2E8F0';

  /* ── Multi-dataset bar (boli: testati vs pozitivi) ── */
  if (cfg.multi && chartType === 'bar') {
    const labels = [...new Set(rows.map(r => String(r[cfg.labelKey] ?? '')))];
    const datasets = cfg.datasets.map(ds => {
      const data = labels.map(lbl => {
        return rows.filter(r => String(r[cfg.labelKey]) === lbl)
                   .reduce((s, r) => s + (parseFloat(r[ds.key]) || 0), 0);
      });
      return {
        label: ds.label, data,
        backgroundColor: ds.color + '99',
        borderColor: ds.color,
        borderWidth: 1.5,
        borderRadius: 4,
      };
    });
    return {
      type: 'bar',
      data: { labels, datasets },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
          legend: { position: 'top', labels: { font: fontDef, padding: 14, usePointStyle: true } },
          tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString('ro-RO')}` } },
        },
        scales: {
          x: { grid: { color: gridColor }, ticks: { font: fontDef } },
          y: { grid: { color: gridColor }, ticks: { font: fontDef } },
        },
      },
    };
  }

  /* ── Simple bar ── */
  if (chartType === 'bar') {
    const { labels, values } = aggregate(rows, cfg.labelKey, cfg.valueKey);
    const bg = labels.map((_, i) => CHART_COLORS[i % CHART_COLORS.length] + 'BB');
    const br = labels.map((_, i) => CHART_COLORS[i % CHART_COLORS.length]);
    const barCfg = {
      type: 'bar',
      data: { labels, datasets: [{ label: cfg.label, data: values, backgroundColor: bg, borderColor: br, borderWidth: 1.5, borderRadius: 4 }] },
      options: {
        responsive: true, maintainAspectRatio: false,
        indexAxis: cfg.horiz ? 'y' : 'x',
        plugins: {
          legend: { display: false },
          tooltip: { callbacks: { label: ctx => ` ${(cfg.horiz ? ctx.parsed.x : ctx.parsed.y).toLocaleString('ro-RO')}` } },
        },
        scales: {
          x: { grid: { color: gridColor }, ticks: { font: fontDef } },
          y: { grid: { color: gridColor }, ticks: { font: fontDef } },
        },
      },
    };
    if (isDrillable(section, 'bar')) {
      barCfg.options.onClick = (event, elements) => {
        if (!elements.length) return;
        openDrugModal(section, labels[elements[0].index]);
      };
      barCfg.options.onHover = (event, elements) => {
        const t = event.native?.target;
        if (t) t.style.cursor = elements.length ? 'pointer' : 'default';
      };
    }
    return barCfg;
  }

  /* ── Doughnut ── */
  if (chartType === 'pie') {
    const { labels, values } = aggregate(rows, cfg.labelKey, cfg.valueKey);
    const bg = labels.map((_, i) => CHART_COLORS[i % CHART_COLORS.length] + 'BB');
    const br = labels.map((_, i) => CHART_COLORS[i % CHART_COLORS.length]);
    const pieCfg = {
      type: 'doughnut',
      data: { labels, datasets: [{ label: cfg.label, data: values, backgroundColor: bg, borderColor: br, borderWidth: 2, hoverOffset: 8 }] },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
          legend: { position: 'right', labels: { font: fontDef, padding: 14, usePointStyle: true, boxWidth: 12 } },
          tooltip: {
            callbacks: {
              label: ctx => {
                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                return ` ${ctx.label}: ${ctx.parsed.toLocaleString('ro-RO')} (${pct}%)`;
              },
            },
          },
        },
        cutout: '52%',
      },
    };
    if (isDrillable(section, 'pie')) {
      pieCfg.options.onClick = (event, elements) => {
        if (!elements.length) return;
        openDrugModal(section, labels[elements[0].index]);
      };
      pieCfg.options.onHover = (event, elements) => {
        const t = event.native?.target;
        if (t) t.style.cursor = elements.length ? 'pointer' : 'default';
      };
    }
    return pieCfg;
  }

  return null;
}

// ── Render chart ──────────────────────────────────────────────────
function renderChart(section, rows, chartType) {
  const container = document.getElementById('result-' + section);
  if (!container) return;

  if (chartInstances[section]) {
    chartInstances[section].destroy();
    chartInstances[section] = null;
  }

  if (!rows || !rows.length) {
    container.innerHTML = '<div class="empty-state"><p>Niciun rezultat de afișat.</p></div>';
    return;
  }

  const config = buildChartConfig(section, rows, chartType);
  if (!config) return;

  const hint = isDrillable(section, chartType)
    ? '<p class="chart-hint"><svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 8v4m0 4h.01"/></svg> Apasă pe un element din grafic pentru mai multe detalii</p>'
    : '';
  container.innerHTML = `<div class="chart-container"><canvas id="chart-${section}"></canvas></div>${hint}`;
  const ctx = document.getElementById('chart-' + section);
  chartInstances[section] = new Chart(ctx, config);
}

// ── Render data (dispatch to table or chart) ──────────────────────
function renderData(section, rows) {
  const view = currentView[section] || 'table';

  // Update result count chip
  const headerEl = document.getElementById('header-' + section);
  const countEl  = document.getElementById('count-' + section);
  if (headerEl) headerEl.style.display = '';
  if (countEl) {
    const n = rows ? rows.length : 0;
    countEl.textContent = n + ' rezultat' + (n !== 1 ? 'e' : '') + ' gasite';
  }

  if (view === 'table') {
    const resultEl = document.getElementById('result-' + section);
    if (resultEl) {
      resultEl.innerHTML = renderTable(section, rows);
      // Bind sortable column headers
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

// ── Tab switching ─────────────────────────────────────────────────
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    btn.classList.add('active');
    const section = btn.dataset.section;
    document.getElementById('sec-' + section)?.classList.add('active');
    // Auto-load first visit
    if (!visitedTabs.has(section)) {
      visitedTabs.add(section);
      const form = document.querySelector('#sec-' + section + ' .ajax-form');
      if (form) form.dispatchEvent(new Event('submit'));
    }
  });
});

// ── View toggle ───────────────────────────────────────────────────
document.querySelectorAll('.view-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const section = btn.dataset.section;
    const view    = btn.dataset.view;
    currentView[section] = view;
    document.querySelectorAll('#toggle-' + section + ' .view-btn').forEach(b => {
      b.classList.toggle('active', b.dataset.view === view);
    });
    if (sectionData[section]) renderData(section, sectionData[section]);
  });
});

// ── Populate dropdowns from /filters ─────────────────────────────
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
    // Auto-load the first (active) tab
    if (!visitedTabs.has('confiscari')) {
      visitedTabs.add('confiscari');
      const form = document.querySelector('#sec-confiscari .ajax-form');
      if (form) form.dispatchEvent(new Event('submit'));
    }
  })
  .catch(() => console.error('Filtrele nu s-au putut incarca.'));

// ── AJAX form submit ──────────────────────────────────────────────
document.querySelectorAll('.ajax-form').forEach(form => {
  form.addEventListener('submit', async e => {
    e.preventDefault();
    const section  = form.dataset.section;
    const resultEl = document.getElementById('result-' + section);
    const params   = getFormParams(form);
    params.set('section', section);
    const btn = form.querySelector('button[type="submit"]');

    resultEl.innerHTML = '<div class="loading-state"><div class="spinner"></div><span>Se incarca datele...</span></div>';
    if (btn) btn.disabled = true;

    try {
      const res  = await fetch('api/router.php?' + params.toString());
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

// ── Export ────────────────────────────────────────────────────────
document.querySelectorAll('.btn-export').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const section = btn.dataset.section;
    const format  = btn.dataset.format;
    const form    = document.querySelector('#sec-' + section + ' .ajax-form');
    const params  = getFormParams(form);
    params.set('section', section);
    params.set('format', format);
    window.location.href = 'api/router.php?' + params.toString();
  });
});
