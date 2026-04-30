/* ================================================================
   app.js – AJAX, tab switching, table rendering, export
   ================================================================ */

const COLUMNS = {
  confiscari: [
    { key: 'drog',       label: 'Drog' },
    { key: 'grame',      label: 'Grame' },
    { key: 'comprimate', label: 'Comprimate' },
    { key: 'doze',       label: 'Doze' },
    { key: 'mililitri',  label: 'mL' },
    { key: 'nr_capturi', label: 'Nr. capturi' },
    { key: 'an',         label: 'An' },
  ],
  condamnari: [
    { key: 'numar',       label: 'Nr. condamnați' },
    { key: 'sex',         label: 'Sex',         badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'varsta_grup', label: 'Grup vârstă', badge: { Minor: 'badge-minor', Major: 'badge-major' } },
    { key: 'an',          label: 'An' },
  ],
  urgente: [
    { key: 'categorie',   label: 'Categorie drog' },
    { key: 'sex',         label: 'Sex', badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'nr_pacienti', label: 'Nr. pacienți' },
    { key: 'an',          label: 'An' },
  ],
  tratament: [
    { key: 'categorie',   label: 'Categorie drog' },
    { key: 'regim',       label: 'Regim' },
    { key: 'nr_pacienti', label: 'Nr. pacienți' },
    { key: 'an',          label: 'An' },
  ],
  actiuni: [
    { key: 'proiect',        label: 'Proiect' },
    { key: 'nr_beneficiari', label: 'Nr. beneficiari' },
    { key: 'an',             label: 'An' },
  ],
  boli: [
    { key: 'boala',         label: 'Boală' },
    { key: 'sex',           label: 'Sex', badge: { Masculin: 'badge-m', Feminin: 'badge-f' } },
    { key: 'nr_testati',    label: 'Testați' },
    { key: 'nr_pozitivi',   label: 'Pozitivi' },
    { key: 'rata_pozitivi', label: 'Rată (%)' },
  ],
};

// ── Helpers ───────────────────────────────────────────────────────
function escHtml(str) {
  return String(str)
    .replace(/&/g, '&amp;').replace(/</g, '&lt;')
    .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function getFormParams(form) {
  const params = new URLSearchParams();
  form.querySelectorAll('input, select').forEach(el => {
    if (el.name && el.value.trim() !== '') {
      params.set(el.name, el.value.trim());
    }
  });
  return params;
}

// ── Tab switching ─────────────────────────────────────────────────
document.querySelectorAll('.tab-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('sec-' + btn.dataset.section)?.classList.add('active');
  });
});

// ── Populare dropdown-uri ─────────────────────────────────────────
fetch('api/filters.php')
  .then(r => r.json())
  .then(data => {
    document.querySelectorAll('select[name="drog_id"]').forEach(sel => {
      data.droguri.forEach(item => {
        sel.appendChild(new Option(item.label, item.id));
      });
    });
    document.querySelectorAll('select[name="categorie_id"]').forEach(sel => {
      data.categorii.forEach(item => {
        sel.appendChild(new Option(item.label, item.id));
      });
    });
    document.querySelectorAll('select[name="boala_id"]').forEach(sel => {
      data.boli.forEach(item => {
        sel.appendChild(new Option(item.label, item.id));
      });
    });
  })
  .catch(() => console.error('Filtrele nu s-au putut încărca.'));

// ── Randare tabel ─────────────────────────────────────────────────
function renderTable(rows, cols) {
  if (!rows || !rows.length) {
    return '<p class="empty">Niciun rezultat găsit.</p>';
  }
  const ths = cols.map(c => `<th>${c.label}</th>`).join('');
  const trs = rows.map(row => {
    const tds = cols.map(c => {
      const val = row[c.key] ?? '—';
      if (c.badge && c.badge[val]) {
        return `<td><span class="badge ${c.badge[val]}">${escHtml(val)}</span></td>`;
      }
      return `<td>${escHtml(val)}</td>`;
    }).join('');
    return `<tr>${tds}</tr>`;
  }).join('');

  const n = rows.length;
  return `
    <p class="result-count">${n} rezultat${n !== 1 ? 'e' : ''} găsite</p>
    <table>
      <thead><tr>${ths}</tr></thead>
      <tbody>${trs}</tbody>
    </table>`;
}

// ── AJAX submit ───────────────────────────────────────────────────
document.querySelectorAll('.ajax-form').forEach(form => {
  form.addEventListener('submit', async e => {
    e.preventDefault();

    const endpoint = form.dataset.endpoint;
    const section  = endpoint.replace('api/', '').replace('.php', '');
    const resultEl = document.getElementById('result-' + section);
    const params   = getFormParams(form);
    const btn      = form.querySelector('button[type="submit"]');

    resultEl.innerHTML = '<p class="loading">Se încarcă<span class="dots">...</span></p>';
    btn.disabled = true;

    try {
      const res  = await fetch(endpoint + '?' + params.toString());
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const json = await res.json();

      if (json.error) {
        resultEl.innerHTML = `<p class="empty">Eroare: ${escHtml(json.error)}</p>`;
      } else {
        resultEl.innerHTML = renderTable(json.data, COLUMNS[section] || []);
      }
    } catch (err) {
      resultEl.innerHTML = '<p class="empty">Eroare de rețea. Verifică serverul și încearcă din nou.</p>';
      console.error(err);
    } finally {
      btn.disabled = false;
    }
  });
});

// ── Export ────────────────────────────────────────────────────────
document.querySelectorAll('.btn-export').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const section = btn.dataset.section;
    const format  = btn.dataset.format;
    const form    = document.querySelector(`#sec-${section} .ajax-form`);
    const params  = getFormParams(form);
    params.set('section', section);
    params.set('format', format);
    window.location.href = 'api/export.php?' + params.toString();
  });
});