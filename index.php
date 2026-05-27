<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>DrugExplorer – Statistici Droguri România</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<header class="app-header">
  <div class="header-inner">
    <div class="brand">
      <div>
        <div class="brand-name">Drug<span>Explorer</span></div>
        <div class="brand-tagline">Statistici nationale &middot; Romania</div>
      </div>
    </div>
    <a href="admin.php" class="header-admin-link">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
      Admin
    </a>
  </div>
  <div class="ro-stripe"><div></div><div></div><div></div></div>
</header>

<nav class="tab-nav">
  <div class="tab-inner">
    <ul class="tab-list">
      <li><button class="tab-btn active" data-section="confiscari">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        Confiscari
      </button></li>
      <li><button class="tab-btn" data-section="condamnari">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5 5 0 006 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
        Condamnari
      </button></li>
      <li><button class="tab-btn" data-section="urgente">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        Urgente
      </button></li>
      <li><button class="tab-btn" data-section="tratament">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        Tratament
      </button></li>
      <li><button class="tab-btn" data-section="actiuni">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        Prevenire
      </button></li>
      <li><button class="tab-btn" data-section="boli">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        Boli infectioase
      </button></li>
      <li><button class="tab-btn" data-section="ai-map">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
        Harta AI
      </button></li>
    </ul>
  </div>
</nav>

<main class="app-main">

<!-- ===================== CONFISCARI ===================== -->
<section class="section active" id="sec-confiscari">
  <div class="section-header">
    <h1 class="section-title">Confiscari de droguri</h1>
    <p class="section-desc">Cantitati confiscate si numarul de capturi per tip de drog</p>
  </div>
  <div class="content-grid">
    <div class="card filter-card">
      <div class="card-header"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg> Filtre</div>
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="confiscari">
          <div class="form-row">
            <div class="field"><label for="conf-drog">Tip drog</label><select id="conf-drog" name="drog_id"><option value="">&#8212; Toate &#8212;</option></select></div>
            <div class="field"><label for="conf-an">An</label><input id="conf-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" /></div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cauta</button>
            <a class="btn-export" data-section="confiscari" data-format="csv" href="#">&#8595; CSV</a>
            <a class="btn-export" data-section="confiscari" data-format="json" href="#">&#8595; JSON</a>
          </div>
        </form>
      </div>
    </div>
    <div class="card results-card">
      <div class="card-header results-header" id="header-confiscari" style="display:none">
        <span class="result-count-inline" id="count-confiscari"></span>
        <div class="view-toggle" id="toggle-confiscari">
          <button class="view-btn active" data-section="confiscari" data-view="table"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg> Tabel</button>
          <button class="view-btn" data-section="confiscari" data-view="bar"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Bare</button>
          <button class="view-btn" data-section="confiscari" data-view="pie"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg> Circular</button>
        </div>
      </div>
      <div class="card-body results-body">
        <div class="result-area" id="result-confiscari"><div class="empty-state"><svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="empty-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg><p>Apasa <strong>Cauta</strong> pentru a incarca datele</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== CONDAMNARI ===================== -->
<section class="section" id="sec-condamnari">
  <div class="section-header">
    <h1 class="section-title">Condamnari &middot; profil demografic</h1>
    <p class="section-desc">Numarul de condamnari grupate pe sex si categorie de varsta</p>
  </div>
  <div class="content-grid">
    <div class="card filter-card">
      <div class="card-header"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg> Filtre</div>
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="condamnari">
          <div class="form-row">
            <div class="field"><label for="cond-an">An</label><input id="cond-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" /></div>
            <div class="field"><label for="cond-sex">Sex</label><select id="cond-sex" name="sex"><option value="">&#8212; Ambele &#8212;</option><option value="Masculin">Masculin</option><option value="Feminin">Feminin</option></select></div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cauta</button>
            <a class="btn-export" data-section="condamnari" data-format="csv" href="#">&#8595; CSV</a>
            <a class="btn-export" data-section="condamnari" data-format="json" href="#">&#8595; JSON</a>
          </div>
        </form>
      </div>
    </div>
    <div class="card results-card">
      <div class="card-header results-header" id="header-condamnari" style="display:none">
        <span class="result-count-inline" id="count-condamnari"></span>
        <div class="view-toggle" id="toggle-condamnari">
          <button class="view-btn active" data-section="condamnari" data-view="table"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg> Tabel</button>
          <button class="view-btn" data-section="condamnari" data-view="bar"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Bare</button>
          <button class="view-btn" data-section="condamnari" data-view="pie"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg> Circular</button>
        </div>
      </div>
      <div class="card-body results-body">
        <div class="result-area" id="result-condamnari"><div class="empty-state"><svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="empty-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 6l3 1m0 0l-3 9a5 5 0 006 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg><p>Apasa <strong>Cauta</strong> pentru a incarca datele</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== URGENTE ===================== -->
<section class="section" id="sec-urgente">
  <div class="section-header">
    <h1 class="section-title">Urgente medicale</h1>
    <p class="section-desc">Numar de pacienti prezentati la urgente, pe categorie de drog si sex</p>
  </div>
  <div class="content-grid">
    <div class="card filter-card">
      <div class="card-header"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg> Filtre</div>
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="urgente">
          <div class="form-row">
            <div class="field"><label for="urg-cat">Categorie drog</label><select id="urg-cat" name="categorie_id"><option value="">&#8212; Toate &#8212;</option></select></div>
            <div class="field"><label for="urg-an">An</label><input id="urg-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" /></div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cauta</button>
            <a class="btn-export" data-section="urgente" data-format="csv" href="#">&#8595; CSV</a>
            <a class="btn-export" data-section="urgente" data-format="json" href="#">&#8595; JSON</a>
          </div>
        </form>
      </div>
    </div>
    <div class="card results-card">
      <div class="card-header results-header" id="header-urgente" style="display:none">
        <span class="result-count-inline" id="count-urgente"></span>
        <div class="view-toggle" id="toggle-urgente">
          <button class="view-btn active" data-section="urgente" data-view="table"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg> Tabel</button>
          <button class="view-btn" data-section="urgente" data-view="bar"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Bare</button>
          <button class="view-btn" data-section="urgente" data-view="pie"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg> Circular</button>
        </div>
      </div>
      <div class="card-body results-body">
        <div class="result-area" id="result-urgente"><div class="empty-state"><svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="empty-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg><p>Apasa <strong>Cauta</strong> pentru a incarca datele</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== TRATAMENT ===================== -->
<section class="section" id="sec-tratament">
  <div class="section-header">
    <h1 class="section-title">Regim de tratament</h1>
    <p class="section-desc">Pacienti in tratament, pe categorie de drog si regim de ingrijire</p>
  </div>
  <div class="content-grid">
    <div class="card filter-card">
      <div class="card-header"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg> Filtre</div>
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="tratament">
          <div class="form-row">
            <div class="field"><label for="trat-cat">Categorie drog</label><select id="trat-cat" name="categorie_id"><option value="">&#8212; Toate &#8212;</option></select></div>
            <div class="field"><label for="trat-an">An</label><input id="trat-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" /></div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cauta</button>
            <a class="btn-export" data-section="tratament" data-format="csv" href="#">&#8595; CSV</a>
            <a class="btn-export" data-section="tratament" data-format="json" href="#">&#8595; JSON</a>
          </div>
        </form>
      </div>
    </div>
    <div class="card results-card">
      <div class="card-header results-header" id="header-tratament" style="display:none">
        <span class="result-count-inline" id="count-tratament"></span>
        <div class="view-toggle" id="toggle-tratament">
          <button class="view-btn active" data-section="tratament" data-view="table"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg> Tabel</button>
          <button class="view-btn" data-section="tratament" data-view="bar"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Bare</button>
          <button class="view-btn" data-section="tratament" data-view="pie"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg> Circular</button>
        </div>
      </div>
      <div class="card-body results-body">
        <div class="result-area" id="result-tratament"><div class="empty-state"><svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="empty-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg><p>Apasa <strong>Cauta</strong> pentru a incarca datele</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== ACTIUNI ===================== -->
<section class="section" id="sec-actiuni">
  <div class="section-header">
    <h1 class="section-title">Proiecte de prevenire</h1>
    <p class="section-desc">Proiecte si activitati de prevenire a consumului de droguri</p>
  </div>
  <div class="content-grid">
    <div class="card filter-card">
      <div class="card-header"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg> Filtre</div>
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="actiuni">
          <div class="form-row">
            <div class="field"><label for="act-an">An</label><input id="act-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" /></div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cauta</button>
            <a class="btn-export" data-section="actiuni" data-format="csv" href="#">&#8595; CSV</a>
            <a class="btn-export" data-section="actiuni" data-format="json" href="#">&#8595; JSON</a>
          </div>
        </form>
      </div>
    </div>
    <div class="card results-card">
      <div class="card-header results-header" id="header-actiuni" style="display:none">
        <span class="result-count-inline" id="count-actiuni"></span>
        <div class="view-toggle" id="toggle-actiuni">
          <button class="view-btn active" data-section="actiuni" data-view="table"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg> Tabel</button>
          <button class="view-btn" data-section="actiuni" data-view="bar"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Bare</button>
          <button class="view-btn" data-section="actiuni" data-view="pie"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg> Circular</button>
        </div>
      </div>
      <div class="card-body results-body">
        <div class="result-area" id="result-actiuni"><div class="empty-state"><svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="empty-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg><p>Apasa <strong>Cauta</strong> pentru a incarca datele</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== BOLI ===================== -->
<section class="section" id="sec-boli">
  <div class="section-header">
    <h1 class="section-title">Boli infectioase</h1>
    <p class="section-desc">Prevalenta bolilor infectioase in randul consumatorilor de droguri, pe sex</p>
  </div>
  <div class="content-grid">
    <div class="card filter-card">
      <div class="card-header"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg> Filtre</div>
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="boli">
          <div class="form-row">
            <div class="field"><label for="boala-sel">Boala</label><select id="boala-sel" name="boala_id"><option value="">&#8212; Toate &#8212;</option></select></div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn-primary"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg> Cauta</button>
            <a class="btn-export" data-section="boli" data-format="csv" href="#">&#8595; CSV</a>
            <a class="btn-export" data-section="boli" data-format="json" href="#">&#8595; JSON</a>
          </div>
        </form>
      </div>
    </div>
    <div class="card results-card">
      <div class="card-header results-header" id="header-boli" style="display:none">
        <span class="result-count-inline" id="count-boli"></span>
        <div class="view-toggle" id="toggle-boli">
          <button class="view-btn active" data-section="boli" data-view="table"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg> Tabel</button>
          <button class="view-btn" data-section="boli" data-view="bar"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Bare</button>
          <button class="view-btn" data-section="boli" data-view="pie"><svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg> Circular</button>
        </div>
      </div>
      <div class="card-body results-body">
        <div class="result-area" id="result-boli"><div class="empty-state"><svg width="44" height="44" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="empty-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg><p>Apasa <strong>Cauta</strong> pentru a incarca datele</p></div></div>
      </div>
    </div>
  </div>
</section>


<!-- ===================== AI MAP ===================== -->
<section class="section" id="sec-ai-map">
  <div class="section-header">
    <h1 class="section-title">Harta consum droguri &middot; Europa</h1>
    <p class="section-desc">Intensitatea consumului de droguri per tara, generata de AI pe baza datelor EMCDDA &middot; actualizare zilnica</p>
  </div>

  <div class="card ai-map-card">
    <div class="card-header ai-map-card-header">
      <span class="ai-card-label">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
        Europa &middot; Consum droguri
      </span>

    </div>
    <div class="card-body ai-map-body">
      <div class="ai-map-wrapper">
        <div id="europe-map" class="europe-map-container">
          <div class="ai-map-loading">
            <svg class="ai-spin" width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Harta se va incarca la accesarea tab-ului...
          </div>
        </div>
        <div id="map-legend" class="map-legend"></div>
      </div>
      <div id="ai-map-tooltip" class="ai-map-tooltip"></div>
      <p id="ai-map-timestamp" class="ai-timestamp"></p>
    </div>
  </div>

  <div class="card ai-summary-card">
    <div class="card-header">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
      Sumar AI
    </div>
    <div class="card-body">
      <p id="ai-summary-text" class="ai-summary-text">Datele se incarca...</p>
    </div>
  </div>

  <div class="card ai-news-card">
    <div class="card-header">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
      Tendinte &amp; Stiri
    </div>
    <div class="card-body">
      <div id="ai-trending-list" class="ai-trending-list">
        <p class="ai-summary-text">Datele se incarca...</p>
      </div>
    </div>
  </div>
</section>

</main>

<!-- ===================== DRUG DETAIL MODAL ===================== -->
<div id="drug-modal" class="drug-modal" role="dialog" aria-modal="true" aria-labelledby="drug-modal-title">
  <div class="drug-modal-overlay" id="drug-modal-overlay"></div>
  <div class="drug-modal-box">
    <div class="drug-modal-head">
      <div>
        <div class="drug-modal-subtitle" id="drug-modal-subtitle"></div>
        <h2 id="drug-modal-title">Detalii</h2>
      </div>
      <button class="drug-modal-close" id="drug-modal-close" aria-label="Inchide">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="drug-modal-body" id="drug-modal-body"></div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/d3@7/dist/d3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/topojson-client@3/dist/topojson-client.min.js"></script>
<script src="js/app.js"></script>
<script src="js/ai_map.js"></script>
</body>
</html>
