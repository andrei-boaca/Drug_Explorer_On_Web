const EUROPE_NUM_TO_A2 = {
  '8':'AL','20':'AD','40':'AT','112':'BY','56':'BE','70':'BA','100':'BG',
  '191':'HR','196':'CY','203':'CZ','208':'DK','233':'EE','246':'FI','250':'FR',
  '276':'DE','300':'GR','348':'HU','352':'IS','372':'IE','380':'IT','428':'LV',
  '438':'LI','440':'LT','442':'LU','470':'MT','498':'MD','492':'MC','499':'ME',
  '528':'NL','807':'MK','578':'NO','616':'PL','620':'PT','642':'RO','643':'RU',
  '674':'SM','688':'RS','703':'SK','705':'SI','724':'ES','752':'SE','756':'CH',
  '804':'UA','826':'GB','336':'VA'
};

const COUNTRY_NAMES_RO = {
  'AL':'Albania','AD':'Andorra','AT':'Austria','BY':'Belarus','BE':'Belgia',
  'BA':'Bosnia-Hertegovina','BG':'Bulgaria','HR':'Croatia','CY':'Cipru',
  'CZ':'Cehia','DK':'Danemarca','EE':'Estonia','FI':'Finlanda','FR':'Franta',
  'DE':'Germania','GR':'Grecia','HU':'Ungaria','IS':'Islanda','IE':'Irlanda',
  'IT':'Italia','LV':'Letonia','LI':'Liechtenstein','LT':'Lituania',
  'LU':'Luxemburg','MT':'Malta','MD':'Moldova','MC':'Monaco','ME':'Muntenegru',
  'NL':'Olanda','MK':'Macedonia de Nord','NO':'Norvegia','PL':'Polonia',
  'PT':'Portugalia','RO':'Romania','RU':'Rusia','SM':'San Marino','RS':'Serbia',
  'SK':'Slovacia','SI':'Slovenia','ES':'Spania','SE':'Suedia','CH':'Elvetia',
  'UA':'Ucraina','GB':'Marea Britanie','VA':'Vatican'
};

function scoreToColor(score) {
  if (score === undefined || score === null) return '#d1d5db';
  const t = Math.max(0, Math.min(10, score)) / 10;
  if (t <= 0.5) {
    const k = t * 2;
    return `rgb(${Math.round(46 + 197 * k)},${Math.round(204 - 48 * k)},${Math.round(113 - 95 * k)})`;
  }
  const k = (t - 0.5) * 2;
  return `rgb(${Math.round(243 - 12 * k)},${Math.round(156 - 80 * k)},${Math.round(18 + 42 * k)})`;
}

async function initAIMap() {
  const mapEl = document.getElementById('europe-map');
  if (!mapEl) return;

  mapEl.innerHTML = `
    <div class="ai-map-loading">
      <svg class="ai-spin" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
      </svg>
      Se incarca datele AI si harta...
    </div>`;

  try {
    const [aiData, worldData] = await Promise.all([
      fetch('api/ai_map_data.php').then(r => r.json()),
      d3.json('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json')
    ]);

    if (aiData.error) throw new Error(aiData.error);

    renderMap(aiData, worldData);
    renderLegend(aiData);
    renderSummary(aiData);
    renderTrending(aiData);

    const ts = document.getElementById('ai-map-timestamp');
    if (ts) {
      const src = aiData.from_cache ? 'date din cache' : 'date proaspete';
      ts.textContent = `Ultima actualizare: ${aiData.updated_at} · ${src} · Sursa: EMCDDA / Claude AI`;
    }

    const badge = document.getElementById('ai-map-status');
    if (badge) {
      badge.textContent  = aiData.from_cache ? 'Cache' : 'Live';
      badge.className    = 'ai-status-badge ' + (aiData.from_cache ? 'badge-cache' : 'badge-live');
    }
  } catch (err) {
    mapEl.innerHTML = `<p class="empty" style="padding:2rem">Eroare la incarcarea datelor AI: ${err.message}</p>`;
    console.error('AI Map error:', err);
  }
}

function renderMap(aiData, worldData) {
  const container = document.getElementById('europe-map');
  container.innerHTML = '';

  const countries = topojson.feature(worldData, worldData.objects.countries);
  const tooltip   = document.getElementById('ai-map-tooltip');

  const W = container.clientWidth  || 700;
  const H = Math.round(W * 0.62);

  const svg = d3.select(container)
    .append('svg')
    .attr('width', '100%')
    .attr('viewBox', `0 0 ${W} ${H}`)
    .attr('preserveAspectRatio', 'xMidYMid meet');

  const projection = d3.geoAzimuthalEqualArea()
    .rotate([-15, -52])
    .translate([W / 2, H / 2])
    .scale(W * 0.95);

  const path = d3.geoPath().projection(projection);

  svg.selectAll('.map-country')
    .data(countries.features)
    .enter()
    .append('path')
    .attr('class', 'map-country')
    .attr('d', path)
    .attr('fill', d => {
      const a2 = EUROPE_NUM_TO_A2[String(d.id)];
      return scoreToColor(a2 ? aiData.scores?.[a2] : undefined);
    })
    .attr('stroke', '#fff')
    .attr('stroke-width', 0.5)
    .on('mousemove', function(event, d) {
      const a2 = EUROPE_NUM_TO_A2[String(d.id)];
      if (!a2) return;
      const score = aiData.scores?.[a2];
      if (score === undefined) return;
      const name = COUNTRY_NAMES_RO[a2] || a2;
      tooltip.innerHTML = `<strong>${name}</strong> &nbsp; Scor: ${score.toFixed(1)} / 10`;
      tooltip.style.display = 'block';
      tooltip.style.left    = (event.offsetX + 16) + 'px';
      tooltip.style.top     = (event.offsetY - 14) + 'px';
      d3.select(this).raise().attr('stroke-width', 2).attr('stroke', '#0b2545');
    })
    .on('mouseleave', function() {
      tooltip.style.display = 'none';
      d3.select(this).attr('stroke-width', 0.5).attr('stroke', '#fff');
    });
}

function renderLegend(aiData) {
  const legend = document.getElementById('map-legend');
  if (!legend) return;

  const scores  = Object.values(aiData.scores || {}).filter(v => typeof v === 'number');
  const min     = Math.min(...scores).toFixed(1);
  const max     = Math.max(...scores).toFixed(1);
  const avgVal  = (scores.reduce((a, b) => a + b, 0) / scores.length).toFixed(1);

  legend.innerHTML = `
    <div class="legend-title">Nivel consum droguri</div>
    <div class="legend-gradient-wrap">
      <div class="legend-bar"></div>
      <div class="legend-bar-labels">
        <span>Scazut</span><span>Mediu</span><span>Ridicat</span>
      </div>
    </div>
    <div class="legend-stats">
      <div class="legend-stat"><span class="ls-dot" style="background:${scoreToColor(parseFloat(min))}"></span><span class="ls-label">Min</span><span class="ls-val">${min}</span></div>
      <div class="legend-stat"><span class="ls-dot" style="background:${scoreToColor(parseFloat(avgVal))}"></span><span class="ls-label">Medie</span><span class="ls-val">${avgVal}</span></div>
      <div class="legend-stat"><span class="ls-dot" style="background:${scoreToColor(parseFloat(max))}"></span><span class="ls-label">Max</span><span class="ls-val">${max}</span></div>
    </div>
    <div class="legend-no-data"><span class="ls-dot" style="background:#d1d5db"></span> Date indisponibile</div>
  `;
}

function renderSummary(aiData) {
  const el = document.getElementById('ai-summary-text');
  if (el && aiData.summary) el.textContent = aiData.summary;
}

function renderTrending(aiData) {
  const list = document.getElementById('ai-trending-list');
  if (!list || !Array.isArray(aiData.trending)) return;

  list.innerHTML = aiData.trending.map(item => {
    const rising  = item.trend === 'rising';
    const score   = aiData.scores?.[item.code];
    const scoreHtml = score !== undefined
      ? `<span class="trending-score" style="background:${scoreToColor(score)};color:#fff">Scor ${score.toFixed(1)}</span>`
      : '';
    return `
      <div class="trending-item">
        <div class="trending-header">
          <span class="trending-country">${item.country}</span>
          <span class="trending-badge ${rising ? 'badge-rising' : 'badge-declining'}">
            ${rising ? '&#8593; In crestere' : '&#8595; In scadere'}
          </span>
          ${scoreHtml}
        </div>
        <p class="trending-reason">${item.reason}</p>
      </div>`;
  }).join('');
}

document.addEventListener('DOMContentLoaded', () => {
  const aiTabBtn = document.querySelector('[data-section="ai-map"]');
  if (!aiTabBtn) return;
  aiTabBtn.addEventListener('click', () => {
    const mapEl = document.getElementById('europe-map');
    if (!mapEl || mapEl.dataset.initialized) return;
    mapEl.dataset.initialized = '1';
    initAIMap();
  });
});
