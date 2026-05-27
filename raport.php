<!DOCTYPE html>
<html lang="ro" prefix="schema: http://schema.org/">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Raport Tehnic – DrugExplorer</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <style>
    .report-main {
      max-width: 860px;
      margin: 0 auto;
      padding: 2rem 1.5rem 4rem;
    }
    .report-hero { margin-bottom: 1.5rem; }
    .report-hero h1 {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--text);
      line-height: 1.3;
      margin-bottom: .5rem;
    }
    .report-hero .report-subtitle { font-size: .82rem; color: var(--text-muted); }
    .report-meta {
      display: flex; flex-wrap: wrap; gap: .4rem 1.4rem;
      margin-bottom: 1.75rem; font-size: .82rem; color: var(--text-muted);
    }
    .report-meta strong { color: var(--text-mid); }

    /* Authors */
    .authors-card { display: flex; flex-wrap: wrap; gap: .6rem; margin-bottom: 1.75rem; }
    .author-chip {
      display: flex; align-items: center; gap: .45rem;
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 999px; padding: .35rem .9rem; font-size: .82rem;
    }
    .author-chip .dot { width: 7px; height: 7px; background: var(--primary); border-radius: 50%; flex-shrink: 0; }
    .author-chip strong { color: var(--text); font-weight: 600; }
    .author-chip span { color: var(--text-muted); }

    /* Abstract */
    .abstract-card {
      background: var(--primary-light); border: 1px solid #bfdbfe;
      border-radius: var(--radius); padding: 1rem 1.35rem; margin-bottom: 1.75rem;
      font-size: .875rem; color: var(--text-mid); line-height: 1.75;
    }
    .abstract-card .abstract-label {
      font-size: .7rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: .08em; color: var(--primary); margin-bottom: .4rem;
    }
    .abstract-card p { margin: 0; }

    /* TOC */
    .toc-card { margin-bottom: 2rem; }
    .toc-card .card-header { font-weight: 700; }
    .toc-body { padding: 1rem 1.35rem; }
    .toc-list { list-style: none; margin: 0; padding: 0; }
    .toc-list > li {
      border-bottom: 1px solid var(--border);
      padding: .45rem 0;
    }
    .toc-list > li:last-child { border-bottom: none; }
    .toc-list > li > a {
      font-weight: 700; font-size: .875rem; color: var(--text);
      text-decoration: none; display: flex; align-items: center; gap: .5rem;
    }
    .toc-list > li > a:hover { color: var(--primary); }
    .toc-num {
      display: inline-flex; align-items: center; justify-content: center;
      width: 22px; height: 22px; background: var(--primary-light);
      color: var(--primary); border-radius: 5px;
      font-size: .75rem; font-weight: 700; flex-shrink: 0;
    }
    .toc-sub { list-style: none; margin: .25rem 0 0 2rem; padding: 0; display: flex; flex-wrap: wrap; gap: .25rem .75rem; }
    .toc-sub li a {
      font-size: .78rem; color: var(--text-muted); text-decoration: none;
    }
    .toc-sub li a:hover { color: var(--primary); text-decoration: underline; }

    /* Section cards */
    .report-section { margin-bottom: 1.5rem; }
    .report-section > .card-header { font-size: .95rem; font-weight: 700; color: var(--text); }
    .report-body { padding: 1.1rem 1.35rem; }

    .report-body h3 {
      font-size: .875rem; font-weight: 700; color: var(--primary);
      margin: 1.4rem 0 .5rem; padding-bottom: .3rem;
      border-bottom: 1px solid var(--border);
    }
    .report-body h3:first-child { margin-top: 0; }

    .report-body p { margin-bottom: .7rem; color: var(--text-mid); font-size: .875rem; line-height: 1.75; }
    .report-body ul, .report-body ol {
      margin: .3rem 0 .7rem 1.3rem; color: var(--text-mid);
      font-size: .875rem; line-height: 1.8;
    }
    .report-body li { margin-bottom: .15rem; }

    .report-body code {
      font-family: 'DM Mono', monospace; font-size: .8em;
      background: var(--primary-light); color: var(--primary-dark);
      padding: .1em .35em; border-radius: 4px;
    }
    .report-body pre {
      background: var(--text); color: #e2e8f0;
      border-radius: var(--radius-sm); padding: 1rem 1.2rem;
      overflow-x: auto; font-size: .8rem; line-height: 1.6; margin: .75rem 0;
    }
    .report-body pre code { background: none; color: inherit; padding: 0; font-size: inherit; }

    /* Tables */
    .report-body table { width: 100%; border-collapse: collapse; margin: .65rem 0; font-size: .84rem; }
    .report-body th {
      background: var(--primary-light); color: var(--primary-dark); font-weight: 600;
      padding: .45rem .7rem; text-align: left; border-bottom: 2px solid var(--primary);
    }
    .report-body td {
      padding: .42rem .7rem; border-bottom: 1px solid var(--border);
      color: var(--text-mid); vertical-align: top;
    }
    .report-body tr:last-child td { border-bottom: none; }
    .report-body tr:hover td { background: #f8fafc; }

    /* Tech cards grid */
    .tech-grid {
      display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: .75rem; margin: .75rem 0;
    }
    .tech-tile {
      border: 1px solid var(--border); border-radius: var(--radius-sm);
      padding: .85rem 1rem; background: var(--surface);
    }
    .tech-tile-head {
      display: flex; flex-direction: column; align-items: flex-start; gap: .3rem; margin-bottom: .5rem;
    }
    .tech-badge {
      font-family: 'DM Mono', monospace; font-size: .7rem; font-weight: 700;
      background: var(--primary-light); color: var(--primary);
      padding: .15em .55em; border-radius: 4px;
      word-break: break-word; max-width: 100%;
    }
    .tech-tile-name { font-weight: 700; font-size: .875rem; color: var(--text); }
    .tech-tile p { font-size: .8rem; color: var(--text-muted); line-height: 1.6; margin: 0; }

    /* Req ID */
    .req-id {
      display: inline-block; font-family: 'DM Mono', monospace; font-size: .74rem;
      background: var(--primary-light); color: var(--primary);
      padding: .1em .5em; border-radius: 4px; font-weight: 700; white-space: nowrap;
    }

    .report-main { counter-reset: section; }

    @media (max-width: 600px) {
      .report-hero h1 { font-size: 1.2rem; }
      .report-body { padding: .9rem; }
      .tech-grid { grid-template-columns: 1fr; }
    }
  </style>
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
      <li><a href="index.php" class="tab-btn">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Înapoi la aplicație
      </a></li>
    </ul>
    <span class="tab-report-link" style="background:var(--primary);border-color:var(--primary);color:#fff;cursor:default;">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      Raport
    </span>
  </div>
</nav>

<main class="report-main" resource="#" typeof="schema:ScholarlyArticle">

  <div class="report-hero">
    <h1 property="schema:name">DrugExplorer: Sistem Web pentru Vizualizarea Statisticilor privind Consumul de Droguri în România</h1>
    <p class="report-subtitle">Raport tehnic</p>
  </div>

  <div class="authors-card">
    <div class="author-chip" property="schema:author" typeof="schema:Person">
      <span class="dot"></span>
      <strong property="schema:name">Alin-Gabriel Răileanu</strong>
      <span>· Grupa 2A1, Facultatea de Informatică UAIC</span>
    </div>
    <div class="author-chip" property="schema:author" typeof="schema:Person">
      <span class="dot"></span>
      <strong property="schema:name">Andrei Boacă</strong>
      <span>· Grupa 2A1, Facultatea de Informatică UAIC</span>
    </div>
  </div>

  <div class="report-meta">
    <span><strong>Curs:</strong> Tehnologii Web</span>
    <span><strong>An academic:</strong> 2025–2026</span>
    <span><strong>Cod sursă:</strong>
      <a href="https://github.com/andrei-boaca/Drug_Explorer_On_Web" style="color:var(--primary)">
        github.com/andrei-boaca/Drug_Explorer_On_Web
      </a>
    </span>
  </div>

  <div class="abstract-card" typeof="sa:Abstract" role="doc-abstract">
    <div class="abstract-label">Rezumat</div>
    <p>
      DrugExplorer este o aplicație web care centralizează și vizualizează statistici naționale
      privind consumul, confiscările, condamnările și tratamentul legat de droguri în România,
      pe baza datelor publice disponibile pentru anii 2021 și 2022. Aplicația oferă filtrare
      interactivă prin AJAX, export în formate CSV și JSON, grafice native implementate pe
      Canvas API, un modul de administrare securizat cu protecție CSRF și o hartă interactivă
      SVG a Europei generată cu ajutorul modelului open-source Llama 3.3 70B (via Groq),
      cu actualizare zilnică și cache persistent în baza de date MySQL.
    </p>
  </div>

  <!-- ══════════ CUPRINS ══════════ -->
  <nav class="card toc-card" aria-label="Cuprins">
    <div class="card-header">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10M4 18h10"/></svg>
      Cuprins
    </div>
    <div class="toc-body">
      <ol class="toc-list">
        <li>
          <a href="#introducere"><span class="toc-num">1</span> Introducere</a>
          <ul class="toc-sub">
            <li><a href="#s11">1.1 Scop</a></li>
            <li><a href="#s12">1.2 Domeniu</a></li>
            <li><a href="#s13">1.3 Definiții și acronime</a></li>
            <li><a href="#s14">1.4 Referințe</a></li>
          </ul>
        </li>
        <li>
          <a href="#descriere"><span class="toc-num">2</span> Descriere generală</a>
          <ul class="toc-sub">
            <li><a href="#s21">2.1 Perspectiva produsului</a></li>
            <li><a href="#s22">2.2 Funcțiile produsului</a></li>
            <li><a href="#s23">2.3 Clase de utilizatori</a></li>
            <li><a href="#s24">2.4 Mediu de operare</a></li>
            <li><a href="#s25">2.5 Constrângeri</a></li>
            <li><a href="#s26">2.6 Ipoteze și dependențe</a></li>
          </ul>
        </li>
        <li>
          <a href="#interfete"><span class="toc-num">3</span> Cerințe de interfață externă</a>
          <ul class="toc-sub">
            <li><a href="#s31">3.1 Interfața utilizator</a></li>
            <li><a href="#s32">3.2 Interfețe software</a></li>
            <li><a href="#s33">3.3 Comunicații</a></li>
          </ul>
        </li>
        <li>
          <a href="#cerinte-functionale"><span class="toc-num">4</span> Cerințe funcționale</a>
          <ul class="toc-sub">
            <li><a href="#s41">4.1 Vizualizare statistici</a></li>
            <li><a href="#s42">4.2 Export date</a></li>
            <li><a href="#s43">4.3 Hartă AI Europa</a></li>
            <li><a href="#s44">4.4 Modul admin</a></li>
          </ul>
        </li>
        <li>
          <a href="#cerinte-nonfunctionale"><span class="toc-num">5</span> Cerințe non-funcționale</a>
          <ul class="toc-sub">
            <li><a href="#s51">5.1 Securitate</a></li>
            <li><a href="#s52">5.2 Performanță</a></li>
            <li><a href="#s53">5.3 Disponibilitate</a></li>
            <li><a href="#s54">5.4 Compatibilitate</a></li>
            <li><a href="#s55">5.5 Mentenabilitate</a></li>
          </ul>
        </li>
        <li>
          <a href="#arhitectura"><span class="toc-num">6</span> Arhitectura tehnică</a>
          <ul class="toc-sub">
            <li><a href="#s61">6.1 Stiva tehnologică</a></li>
            <li><a href="#s62">6.2 Detalii tehnologii</a></li>
            <li><a href="#s63">6.3 Schema bazei de date</a></li>
            <li><a href="#s64">6.4 Fluxul AI</a></li>
            <li><a href="#s65">6.5 Structura fișierelor</a></li>
          </ul>
        </li>
      </ol>
    </div>
  </nav>

  <!-- ══ 1. Introducere ══ -->
  <section class="report-section card" id="introducere">
    <div class="card-header">1. Introducere</div>
    <div class="report-body">

      <h3 id="s11">1.1 Scop</h3>
      <p>
        Acest document descrie cerințele funcționale și non-funcționale ale aplicației web
        DrugExplorer. Publicul vizat include evaluatorii cursului de Tehnologii Web, dar și
        orice utilizator interesat de statistici privind drogurile în România. Documentul
        urmează structura IEEE Std 830-1998 <em>Recommended Practice for Software Requirements
        Specifications</em>, adaptată pentru un proiect web academic.
      </p>

      <h3 id="s12">1.2 Domeniu</h3>
      <p>
        Aplicația operează exclusiv cu date statistice cu caracter public, fără colectarea
        vreunor date personale. Sursele de date sunt rapoartele anuale ale Agenției Naționale
        Antidrog (ANA) și datele comparative europene oferite de EMCDDA.
        Funcționalitățile principale acoperite sunt:
      </p>
      <ul>
        <li>vizualizarea tabelară și grafică a statisticilor naționale (confiscări, condamnări, urgențe medicale, tratament, prevenire, boli infecțioase);</li>
        <li>filtrarea datelor după criterii multiple (tip drog, an, sex, categorie);</li>
        <li>exportul datelor filtrate în format CSV și JSON;</li>
        <li>harta interactivă a Europei cu scoruri de consum generate de AI, actualizate zilnic;</li>
        <li>modulul de administrare cu operații CRUD securizate.</li>
      </ul>

      <h3 id="s13">1.3 Definiții și acronime</h3>
      <table>
        <thead><tr><th>Termen</th><th>Definiție</th></tr></thead>
        <tbody>
          <tr><td>ANA</td><td>Agenția Națională Antidrog</td></tr>
          <tr><td>EMCDDA</td><td>European Monitoring Centre for Drugs and Drug Addiction</td></tr>
          <tr><td>AJAX</td><td>Asynchronous JavaScript and XML – comunicare client-server fără reîncărcarea paginii</td></tr>
          <tr><td>PDO</td><td>PHP Data Objects – interfață abstractă pentru accesul la baze de date</td></tr>
          <tr><td>CSRF</td><td>Cross-Site Request Forgery – atac contracarat prin token de sesiune</td></tr>
          <tr><td>XSS</td><td>Cross-Site Scripting – atac contracarat prin escaping HTML</td></tr>
          <tr><td>SQLi</td><td>SQL Injection – atac contracarat prin prepared statements</td></tr>
          <tr><td>LLM</td><td>Large Language Model – model de limbaj de mari dimensiuni</td></tr>
          <tr><td>Groq</td><td>Platformă de inferență AI utilizată pentru modelul Llama 3.3</td></tr>
          <tr><td>SRS</td><td>Software Requirements Specification</td></tr>
          <tr><td>CRUD</td><td>Create, Read, Update, Delete – operații de bază pe date</td></tr>
          <tr><td>SPA</td><td>Single-Page Application – aplicație web cu o singură pagină HTML</td></tr>
          <tr><td>CDN</td><td>Content Delivery Network – rețea de distribuție a conținutului static</td></tr>
        </tbody>
      </table>

      <h3 id="s14">1.4 Referințe</h3>
      <ul>
        <li>IEEE Std 830-1998, <em>IEEE Recommended Practice for Software Requirements Specifications</em></li>
        <li>W3C Scholarly HTML – <a href="https://w3c.github.io/scholarly-html/" style="color:var(--primary)">w3c.github.io/scholarly-html</a></li>
        <li>EMCDDA European Drug Report 2023 – <a href="https://www.emcdda.europa.eu" style="color:var(--primary)">emcdda.europa.eu</a></li>
        <li>Meta Llama 3.3 Model Card – <a href="https://llama.meta.com" style="color:var(--primary)">llama.meta.com</a></li>
        <li>Groq API Documentation – <a href="https://console.groq.com/docs" style="color:var(--primary)">console.groq.com/docs</a></li>
        <li>MDN Web Docs – Canvas API – <a href="https://developer.mozilla.org/en-US/docs/Web/API/Canvas_API" style="color:var(--primary)">developer.mozilla.org</a></li>
        <li>D3.js Documentation – <a href="https://d3js.org" style="color:var(--primary)">d3js.org</a></li>
      </ul>
    </div>
  </section>

  <!-- ══ 2. Descriere generală ══ -->
  <section class="report-section card" id="descriere">
    <div class="card-header">2. Descriere generală</div>
    <div class="report-body">

      <h3 id="s21">2.1 Perspectiva produsului</h3>
      <p>
        DrugExplorer este un sistem web de sine stătător, fără dependențe față de alte
        sisteme externe cu excepția API-ului Groq (opțional, utilizat cel mult o dată pe zi).
        Aplicația funcționează în arhitectura clasică client-server: browser web ca client,
        server Apache cu PHP 8.3 și bază de date MySQL 8.0.
      </p>
      <p>
        Spre deosebire de soluțiile existente care prezintă rapoartele ANA ca documente PDF
        statice, DrugExplorer oferă interactivitate completă: filtrare, sortare, vizualizare
        grafică și export, toate fără reîncărcarea paginii.
      </p>

      <h3 id="s22">2.2 Funcțiile produsului</h3>
      <ul>
        <li><strong>Vizualizare statistici</strong> – șase secțiuni tematice cu date din 2021–2022.</li>
        <li><strong>Filtrare interactivă</strong> – câmpuri de filtrare cu trimitere AJAX prin Fetch API.</li>
        <li><strong>Vizualizare grafică</strong> – grafice bară și circular implementate nativ pe Canvas API, fără biblioteci externe de grafice.</li>
        <li><strong>Detalii per drog</strong> – modal cu defalcarea completă a datelor asociate unui drog.</li>
        <li><strong>Export date</strong> – CSV (cu BOM UTF-8 pentru compatibilitate Excel) și JSON.</li>
        <li><strong>Hartă AI Europa</strong> – hartă SVG interactivă generată de Llama 3.3 70B, stocată în baza de date cu actualizare zilnică.</li>
        <li><strong>Modul admin</strong> – CRUD autentificat pentru tipuri de droguri și categorii, cu protecție CSRF.</li>
      </ul>

      <h3 id="s23">2.3 Clase de utilizatori</h3>
      <table>
        <thead><tr><th>Clasă</th><th>Caracteristici</th><th>Nivel de acces</th></tr></thead>
        <tbody>
          <tr><td>Vizitator</td><td>Orice persoană interesată de statistici; fără autentificare</td><td>Citire, filtrare, export, hartă AI</td></tr>
          <tr><td>Administrator</td><td>Persoană autorizată cu credențiale de admin</td><td>CRUD tipuri droguri și categorii, statistici agregate</td></tr>
        </tbody>
      </table>

      <h3 id="s24">2.4 Mediu de operare</h3>
      <ul>
        <li><strong>Server:</strong> Apache 2.4, PHP 8.3, MySQL 8.0, extensia <code>php-curl</code> activată</li>
        <li><strong>Client:</strong> orice browser modern cu suport ES2017+, Canvas API și Fetch API (Chrome 90+, Firefox 88+, Edge 90+, Safari 14+)</li>
        <li><strong>Conexiune externă:</strong> API Groq (<code>https://api.groq.com</code>) — necesară doar la primul acces sau la expirarea cache-ului de 24h</li>
      </ul>

      <h3 id="s25">2.5 Constrângeri de proiectare</h3>
      <ul>
        <li>Nu se utilizează framework-uri front-end (React, Angular, Vue, Bootstrap); interfața este implementată exclusiv în HTML5, CSS3 și JavaScript vanilla.</li>
        <li>Nu se utilizează framework-uri back-end (Laravel, Symfony); back-end-ul este PHP pur organizat cu pattern-ul Controller–Service–Repository.</li>
        <li>Graficele sunt implementate exclusiv pe Canvas API nativ, fără Chart.js sau alte biblioteci de grafice.</li>
        <li>Cheia API Groq este stocată ca variabilă de mediu pe server (<code>getenv('GROQ_API_KEY')</code>), nu în codul sursă versionat.</li>
      </ul>

      <h3 id="s26">2.6 Ipoteze și dependențe</h3>
      <ul>
        <li>Datele statistice importate reflectă rapoartele ANA pentru 2021–2022 și nu se actualizează automat.</li>
        <li>Funcționalitatea hărții AI depinde de disponibilitatea serviciului Groq; în caz de indisponibilitate, sunt afișate ultimele date stocate în baza de date.</li>
        <li>Cheia API Groq are o perioadă de valabilitate limitată și necesită reînnoire periodică direct pe server.</li>
      </ul>
    </div>
  </section>

  <!-- ══ 3. Interfețe externe ══ -->
  <section class="report-section card" id="interfete">
    <div class="card-header">3. Cerințe de interfață externă</div>
    <div class="report-body">

      <h3 id="s31">3.1 Interfața utilizator</h3>
      <p>
        Interfața este o aplicație Single-Page (SPA) implementată fără framework: o singură
        pagină HTML (<code>index.php</code>) cu navigare prin tab-uri și manipulare DOM.
        Tranziția între secțiuni nu generează cereri HTTP noi pentru pagină.
      </p>
      <ul>
        <li><strong>Header sticky</strong> – logo, denumire aplicație, link Admin; rămâne vizibil la scroll.</li>
        <li><strong>Bara de navigare</strong> – șapte tab-uri tematice + link raport tehnic.</li>
        <li><strong>Carduri de filtrare</strong> – formulare specifice fiecărei secțiuni, trimise prin <code>fetch()</code> cu parametri serializați.</li>
        <li><strong>Carduri de rezultate</strong> – tabel sortabil (clic pe header coloană) + toggle grafic (bară/circular) + butoane export CSV/JSON.</li>
        <li><strong>Modal detalii drog</strong> – dialog suprapus cu informații defalcate; se închide prin buton, overlay sau tasta Escape.</li>
        <li><strong>Secțiunea Harta AI</strong> – hartă SVG interactivă cu tooltip la hover, legendă cromatică cu gradient, sumar narativ și secțiunea tendințe.</li>
      </ul>
      <p>Designul este responsiv, adaptat pentru rezoluții 320px–1920px prin CSS Flexbox și Grid, fără media query framework.</p>

      <h3 id="s32">3.2 Interfețe software</h3>
      <table>
        <thead><tr><th>Componentă</th><th>Tip</th><th>Protocol / Format</th></tr></thead>
        <tbody>
          <tr><td>MySQL 8.0</td><td>SGBD relațional</td><td>PDO / SQL (utf8mb4_romanian_ci)</td></tr>
          <tr><td>Groq API</td><td>REST API extern (inferență LLM)</td><td>HTTPS POST / JSON (OpenAI-compatible)</td></tr>
          <tr><td>world-atlas v2 (CDN)</td><td>Date geografice TopoJSON</td><td>HTTPS GET / TopoJSON → GeoJSON</td></tr>
          <tr><td>Google Fonts (CDN)</td><td>Font web (Inter, DM Mono)</td><td>HTTPS / CSS + WOFF2</td></tr>
          <tr><td>D3.js v7 (CDN)</td><td>Bibliotecă vizualizare date</td><td>HTTPS / JavaScript ES module</td></tr>
          <tr><td>TopoJSON Client v3 (CDN)</td><td>Decoder format TopoJSON</td><td>HTTPS / JavaScript</td></tr>
        </tbody>
      </table>

      <h3 id="s33">3.3 Interfețe de comunicații</h3>
      <p>
        Toate cererile AJAX folosesc metoda GET cu parametri în query string
        (ex. <code>api/router.php?section=confiscari&amp;drog_id=3&amp;an=2022</code>).
        Răspunsurile sunt JSON cu encoding UTF-8 și header <code>Content-Type: application/json; charset=utf-8</code>.
        Exporturile sunt livrate prin header <code>Content-Disposition: attachment; filename="sectiune.csv"</code>.
      </p>
    </div>
  </section>

  <!-- ══ 4. Cerințe funcționale ══ -->
  <section class="report-section card" id="cerinte-functionale">
    <div class="card-header">4. Cerințe funcționale</div>
    <div class="report-body">

      <h3 id="s41">4.1 Vizualizare statistici naționale</h3>
      <table>
        <thead><tr><th>ID</th><th>Cerință</th></tr></thead>
        <tbody>
          <tr><td><span class="req-id">CF-01</span></td><td>Sistemul afișează confiscările cu câmpurile: tip drog, grame, comprimate, doze, mililitri, capturi, an.</td></tr>
          <tr><td><span class="req-id">CF-02</span></td><td>Utilizatorul poate filtra după tip drog și/sau an pentru orice secțiune.</td></tr>
          <tr><td><span class="req-id">CF-03</span></td><td>Rezultatele pot fi vizualizate ca tabel sortabil, grafic bară sau grafic circular.</td></tr>
          <tr><td><span class="req-id">CF-04</span></td><td>Clic pe un rând din tabelul de confiscări/urgențe/tratament deschide modalul cu detalii per drog.</td></tr>
          <tr><td><span class="req-id">CF-05</span></td><td>Sistemul afișează condamnările grupate pe sex și vârstă (minor/major).</td></tr>
          <tr><td><span class="req-id">CF-06</span></td><td>Sistemul afișează pacienții de la urgențe pe categorie de drog și sex.</td></tr>
          <tr><td><span class="req-id">CF-07</span></td><td>Sistemul afișează pacienții în tratament pe categorie și regim (ambulatoriu/rezidențial).</td></tr>
          <tr><td><span class="req-id">CF-08</span></td><td>Sistemul afișează beneficiarii acțiunilor de prevenire per proiect.</td></tr>
          <tr><td><span class="req-id">CF-09</span></td><td>Sistemul afișează testați și pozitivi per boală cu calculul automat al ratei de pozitivitate.</td></tr>
          <tr><td><span class="req-id">CF-10</span></td><td>Graficul boli afișează simultan coloanele „Testați" și „Pozitivi" (multi-dataset pe Canvas).</td></tr>
        </tbody>
      </table>

      <h3 id="s42">4.2 Export date</h3>
      <table>
        <thead><tr><th>ID</th><th>Cerință</th></tr></thead>
        <tbody>
          <tr><td><span class="req-id">CF-11</span></td><td>Utilizatorul poate descărca datele afișate în format CSV cu BOM UTF-8 (compatibil Excel).</td></tr>
          <tr><td><span class="req-id">CF-12</span></td><td>Utilizatorul poate descărca datele afișate în format JSON cu indentare (pretty-print).</td></tr>
          <tr><td><span class="req-id">CF-13</span></td><td>Exportul respectă filtrele active în momentul descărcării.</td></tr>
        </tbody>
      </table>

      <h3 id="s43">4.3 Hartă AI Europa</h3>
      <table>
        <thead><tr><th>ID</th><th>Cerință</th></tr></thead>
        <tbody>
          <tr><td><span class="req-id">CF-14</span></td><td>Harta afișează 44 de țări europene colorate pe scara verde–galben–roșu (scor 0–10).</td></tr>
          <tr><td><span class="req-id">CF-15</span></td><td>Hover pe o țară afișează tooltip cu numele și scorul numeric.</td></tr>
          <tr><td><span class="req-id">CF-16</span></td><td>Scorurile sunt generate de Llama 3.3 70B și stocate în MySQL.</td></tr>
          <tr><td><span class="req-id">CF-17</span></td><td>Dacă datele din DB depășesc 24h, sistemul interoghează automat Groq și actualizează baza de date.</td></tr>
          <tr><td><span class="req-id">CF-18</span></td><td>Dacă Groq este indisponibil, sistemul afișează ultimele date stocate, indiferent de vârstă.</td></tr>
          <tr><td><span class="req-id">CF-19</span></td><td>Sub hartă: rezumat narativ generat de AI + 6 tendințe (creștere/scădere) cu explicații detaliate.</td></tr>
        </tbody>
      </table>

      <h3 id="s44">4.4 Modul de administrare</h3>
      <table>
        <thead><tr><th>ID</th><th>Cerință</th></tr></thead>
        <tbody>
          <tr><td><span class="req-id">CF-20</span></td><td>Accesul este protejat prin autentificare cu utilizator și parolă.</td></tr>
          <tr><td><span class="req-id">CF-21</span></td><td>Toate formularele sunt protejate împotriva CSRF prin token generat cu <code>random_bytes(16)</code>.</td></tr>
          <tr><td><span class="req-id">CF-22</span></td><td>Administratorul poate adăuga și șterge tipuri de droguri, cu asociere opțională la o categorie.</td></tr>
          <tr><td><span class="req-id">CF-23</span></td><td>Administratorul poate adăuga și șterge categorii de droguri.</td></tr>
          <tr><td><span class="req-id">CF-24</span></td><td>Panoul afișează statistici agregate (număr înregistrări per tabel principal).</td></tr>
          <tr><td><span class="req-id">CF-25</span></td><td>Ștergerea unei categorii declanșează ștergerea în cascadă a tipurilor de droguri asociate (ON DELETE CASCADE).</td></tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- ══ 5. Cerințe non-funcționale ══ -->
  <section class="report-section card" id="cerinte-nonfunctionale">
    <div class="card-header">5. Cerințe non-funcționale</div>
    <div class="report-body">

      <h3 id="s51">5.1 Securitate</h3>
      <ul>
        <li><strong>Prevenire SQLi:</strong> toate interogările SQL folosesc exclusiv prepared statements PDO cu parametri legați (<code>execute([$val])</code>); nu se construiesc interogări prin concatenare de șiruri.</li>
        <li><strong>Prevenire XSS:</strong> valorile afișate în HTML sunt escapate server-side cu <code>htmlspecialchars($v, ENT_QUOTES, 'UTF-8')</code> și client-side cu funcția <code>escHtml()</code> ce înlocuiește <code>&amp;</code>, <code>&lt;</code>, <code>&gt;</code>, <code>"</code>.</li>
        <li><strong>Protecție CSRF:</strong> token generat cu <code>random_bytes(16)</code>, stocat în sesiune PHP și verificat prin <code>hash_equals()</code> la fiecare POST în modulul admin.</li>
        <li><strong>Cheie API:</strong> stocată ca variabilă de mediu (<code>getenv('GROQ_API_KEY')</code>), niciodată comisă în istoricul git.</li>
        <li><strong>Validare input:</strong> parametrii GET/POST sunt validați prin whitelist pentru string-uri și convertiți cu <code>intval()</code> pentru câmpuri numerice.</li>
        <li><strong>Header securitate:</strong> răspunsurile JSON includ <code>X-Content-Type-Options: nosniff</code> pentru a preveni MIME sniffing.</li>
      </ul>

      <h3 id="s52">5.2 Performanță</h3>
      <ul>
        <li>Răspunsul AJAX pentru o interogare tipică nu depășește 300ms în condiții locale.</li>
        <li>Harta AI utilizează un cache zilnic în MySQL, eliminând latența API-ului extern (30s timeout) pentru 99% din cereri.</li>
        <li>Conexiunea PDO este singleton — o singură instanță per cerere HTTP, indiferent de câte controlere o solicită.</li>
      </ul>

      <h3 id="s53">5.3 Disponibilitate și reziliență</h3>
      <ul>
        <li>Secțiunile de statistici naționale funcționează complet independent de servicii externe; o întrerupere a rețelei nu afectează funcționalitatea de bază.</li>
        <li>Harta AI degradează grațios: indisponibilitatea Groq nu blochează aplicația — sunt afișate datele stocate anterior.</li>
      </ul>

      <h3 id="s54">5.4 Compatibilitate și portabilitate</h3>
      <ul>
        <li>Markup HTML5 valid, CSS3 fără proprietăți vendor-prefixed.</li>
        <li>Design responsiv acoperă rezoluții 320px–1920px fără librării CSS externe.</li>
        <li>Funcționează pe orice hosting cu PHP 8.x, MySQL 8.x și extensia <code>php-curl</code>.</li>
      </ul>

      <h3 id="s55">5.5 Mentenabilitate</h3>
      <ul>
        <li>Back-end-ul urmează pattern-ul Controller–Service–Repository: Controller validează inputul HTTP, Service conține logica de business, Repository execută SQL.</li>
        <li>Adăugarea unei noi secțiuni statistice necesită câte un fișier în fiecare din cele trei straturi, fără modificarea codului existent (<em>Open/Closed Principle</em>).</li>
        <li>Schema completă a bazei de date se află în <code>schema.sql</code>; datele inițiale în fișierele <code>populare_*.sql</code>.</li>
      </ul>
    </div>
  </section>

  <!-- ══ 6. Arhitectura tehnică ══ -->
  <section class="report-section card" id="arhitectura">
    <div class="card-header">6. Arhitectura tehnică</div>
    <div class="report-body">

      <h3 id="s61">6.1 Stiva tehnologică</h3>
      <table>
        <thead><tr><th>Nivel</th><th>Tehnologie</th><th>Versiune</th><th>Rol</th></tr></thead>
        <tbody>
          <tr><td>Prezentare</td><td>HTML5 / CSS3 / JavaScript ES2017</td><td>–</td><td>Interfață utilizator SPA</td></tr>
          <tr><td>Grafice</td><td>Canvas API (nativ browser)</td><td>–</td><td>Grafice bară și circular</td></tr>
          <tr><td>Hartă</td><td>D3.js + TopoJSON Client</td><td>7 / 3</td><td>Proiecție geografică și randare SVG</td></tr>
          <tr><td>Date hartă</td><td>world-atlas (Natural Earth 110m)</td><td>2</td><td>Geometrii țări în format TopoJSON</td></tr>
          <tr><td>Server HTTP</td><td>Apache</td><td>2.4</td><td>Servire fișiere statice și PHP</td></tr>
          <tr><td>Back-end</td><td>PHP</td><td>8.3</td><td>API AJAX, logică business, export, admin</td></tr>
          <tr><td>Bază de date</td><td>MySQL</td><td>8.0</td><td>Stocare statistici și cache AI</td></tr>
          <tr><td>AI / LLM</td><td>Llama 3.3 70B (Meta) via Groq</td><td>–</td><td>Generare scoruri consum și narativ</td></tr>
        </tbody>
      </table>

      <h3 id="s62">6.2 Detalii tehnologii</h3>

      <div class="tech-grid">

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">HTML5</span>
            <span class="tech-tile-name">HTML5 semantic</span>
          </div>
          <p>Structura paginii folosește elemente semantice (<code>&lt;header&gt;</code>, <code>&lt;nav&gt;</code>, <code>&lt;main&gt;</code>, <code>&lt;section&gt;</code>). Atribute <code>data-*</code> sunt utilizate pentru stocarea stării tab-urilor și parametrilor AJAX fără JavaScript global. Formularul de filtrare este un <code>&lt;form&gt;</code> standard interceptat via JavaScript.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">CSS3</span>
            <span class="tech-tile-name">CSS3 Flexbox &amp; Grid</span>
          </div>
          <p>Layout-ul folosește Flexbox pentru header, navigare și carduri, și CSS Grid pentru grila de filtre și rezultate. Variabilele CSS (<code>:root { --primary: ... }</code>) centralizează paleta de culori și valorile de spacing, permițând modificarea temei dintr-un singur loc. Media queries acoperă breakpoints la 600px și 1024px.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">JS ES2017</span>
            <span class="tech-tile-name">JavaScript Vanilla</span>
          </div>
          <p>Codul client folosește <code>async/await</code> cu <code>fetch()</code> pentru toate cererile AJAX. Gestionarea stării UI (secțiune activă, date cache per secțiune, sortare coloane) se face prin obiecte JavaScript simple, fără biblioteci de state management. Renderizarea tabelelor și graficelor este realizată prin generare dinamică de HTML și operații pe Canvas.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">Canvas API</span>
            <span class="tech-tile-name">Grafice native</span>
          </div>
          <p>Graficele bară (verticale, orizontale, multi-dataset) și cele circulare sunt implementate direct pe <code>&lt;canvas&gt;</code> folosind Context2D. Includ suport pentru DPI ridicat (<code>devicePixelRatio</code>), etichete truniate dinamic, grilă și axe, hover interactiv și animații la prima randare. Nu se folosește nicio bibliotecă externă de grafice.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">PHP 8.3</span>
            <span class="tech-tile-name">PHP back-end</span>
          </div>
          <p>Back-end-ul organizat în pattern-ul Controller–Service–Repository. PHP 8.3 aduce tipare de proprietăți în constructor (<em>constructor property promotion</em>), enum-uri, <code>match</code> expressions și tipuri union. Sesiunile PHP sunt utilizate pentru autentificarea modulului admin și stocarea token-ului CSRF. Extensia <code>php-curl</code> este necesară pentru apelurile la API-ul Groq.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">PDO</span>
            <span class="tech-tile-name">PHP Data Objects</span>
          </div>
          <p>Toate interogările SQL folosesc prepared statements PDO cu modul <code>ERRMODE_EXCEPTION</code> și <code>EMULATE_PREPARES = false</code> (prepared statements reale pe server MySQL). Conexiunea este singleton — instanțiată o singură dată per cerere HTTP prin funcția <code>getConnection()</code> din <code>config.php</code>.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">MySQL 8.0</span>
            <span class="tech-tile-name">Bază de date</span>
          </div>
          <p>Schema conține 26 de tabele cu chei primare auto-increment, chei străine cu <code>ON DELETE CASCADE</code> și collation <code>utf8mb4_romanian_ci</code> pentru sortare corectă a caracterelor românești (ș, ț, ă etc.). Tabelele cache AI (<code>ai_tari_scoruri</code>, <code>ai_tendinte</code>, <code>ai_sumar</code>) au indecși pe coloanele <code>cod_tara</code> și <code>updated_at</code> pentru interogări rapide.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">D3.js v7</span>
            <span class="tech-tile-name">Vizualizare geografică</span>
          </div>
          <p>D3.js este utilizat exclusiv pentru calculul proiecției geografice a hărții (<code>d3.geoAzimuthalEqualArea()</code>) și generarea path-urilor SVG ale granițelor de țară. Proiecția azimutal-echivalentă este centrată pe Europa (rotație −15°, −52°) pentru o reprezentare optimă a continentului. Nu se utilizează pentru alte componente ale interfeței.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">TopoJSON</span>
            <span class="tech-tile-name">Date geografice</span>
          </div>
          <p>TopoJSON Client v3 decodifică fișierul <code>countries-110m.json</code> din pachetul <em>world-atlas</em> (Natural Earth 110m rezoluție). Fiecare țară este identificată prin ID numeric ISO 3166-1, mapat la cod alpha-2 prin dicționarul <code>EUROPE_NUM_TO_A2</code> din <code>ai_map.js</code> pentru 44 de țări europene.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">Llama 3.3</span>
            <span class="tech-tile-name">Model AI open-source</span>
          </div>
          <p>Llama 3.3 70B Versatile este un model de limbaj mare open-source dezvoltat de Meta AI, disponibil sub licență Llama 3.3 Community License. Modelul este accesat prin platforma Groq cu API compatibil OpenAI. Temperatura setată la 0.3 asigură răspunsuri consistente și reproductibile. Promptul solicită strict JSON fără markdown, cu scoruri 0–10 pentru 44 de țări + 6 tendințe + sumar.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">Groq API</span>
            <span class="tech-tile-name">Inferență AI</span>
          </div>
          <p>Groq oferă inferență LLM cu latență redusă prin hardware specializat (LPU — Language Processing Unit). API-ul este compatibil cu formatul OpenAI Chat Completions. Apelul folosește <code>php-curl</code> cu timeout 30s, model <code>llama-3.3-70b-versatile</code> și <code>max_tokens: 4096</code> pentru a evita trunchiera răspunsului JSON.</p>
        </div>

        <div class="tech-tile">
          <div class="tech-tile-head">
            <span class="tech-badge">CSR Pattern</span>
            <span class="tech-tile-name">Controller – Service – Repository</span>
          </div>
          <p><strong>Controller</strong> — validează parametrii HTTP și apelează Service-ul. <strong>Service</strong> — conține logica de business (agregări, transformări). <strong>Repository</strong> — execută interogările SQL prin PDO. Această separare permite testarea Service-ului independent de HTTP și Repository, și extinderea ușoară cu noi secțiuni.</p>
        </div>

      </div>

      <h3 id="s63">6.3 Schema bazei de date</h3>
      <p>
        Baza de date <code>statistici_droguri</code> conține 26 de tabele în două categorii:
      </p>
      <ul>
        <li><strong>23 tabele statistice:</strong> <code>categorii_droguri</code>, <code>tipuri_droguri</code>, <code>confiscari</code>, <code>condamnari</code>, <code>lege_condamnari</code>, <code>legi</code>, <code>regim_tratament</code>, <code>sex_pacienti</code>, <code>varsta_pacienti</code>, <code>surse</code>, <code>situatie_locativa</code>, <code>nivel_educational</code>, <code>ocupatie_pacienti</code>, <code>sex_urgente</code>, <code>varsta_urgente</code>, <code>cale_administrare</code>, <code>diagnostic_urgenta</code>, <code>actiuni</code>, <code>proiecte</code>, <code>precursori</code>, <code>substante</code>, <code>boli</code>, <code>prevalenta_sex</code>, <code>prevalenta_varsta</code>, <code>prevalenta_timp_prima_injectare</code>.</li>
        <li><strong>3 tabele cache AI:</strong> <code>ai_tari_scoruri</code> (scor per țară + timestamp), <code>ai_tendinte</code> (trend + motiv per țară), <code>ai_sumar</code> (text narativ general, ID fix = 1).</li>
      </ul>

      <h3 id="s64">6.4 Fluxul de date pentru harta AI</h3>
      <ol>
        <li>La accesarea tab-ului „Harta AI", JavaScript trimite o cerere <code>fetch()</code> la <code>api/ai_map_data.php</code> în paralel cu încărcarea datelor geografice din CDN.</li>
        <li>PHP verifică dacă există date în <code>ai_sumar</code> mai noi de 24h.
          <ul>
            <li><strong>DA (cache valid)</strong> → returnează imediat date din cele 3 tabele AI.</li>
            <li><strong>NU (cache expirat)</strong> → apelează Groq cu modelul <code>llama-3.3-70b-versatile</code>; la succes, șterge și reînlocuiește datele din cele 3 tabele AI într-o tranzacție atomică, returnează datele proaspete.</li>
            <li><strong>Groq indisponibil</strong> → returnează ultimele date stocate indiferent de vârstă (<em>stale fallback</em>).</li>
          </ul>
        </li>
        <li>JavaScript colorează path-urile SVG ale fiecărei țări prin funcția <code>scoreToColor(score)</code> cu gradientul verde–galben–roșu, randează legenda și secțiunile de sumar și tendințe.</li>
      </ol>

      <h3 id="s65">6.5 Structura fișierelor</h3>
      <pre><code>Drug_Explorer_On_Web/
├── index.php               # Pagina principală (SPA)
├── admin.php               # Modul administrare (autentificare + CRUD)
├── raport.php              # Documentație Scholarly HTML (acest fișier)
├── config.php              # Configurare DB și cheie API (getenv)
├── style.css               # Stiluri globale (CSS variables, responsive)
├── schema.sql              # Definiție completă schemă bază de date
├── populare_2021.sql       # Date statistice 2021
├── populare_2022.sql       # Date statistice 2022
├── populare_extra.sql      # Date suplimentare (min 50 rânduri per tabel)
├── api/
│   ├── router.php          # Router AJAX (dispatcher secțiuni + export)
│   ├── _base.php           # Helpers: intParam(), strParam(), respondError()
│   └── ai_map_data.php     # Endpoint date hartă AI (cache DB + Groq fallback)
├── js/
│   ├── app.js              # AJAX, tabele sortabile, grafice Canvas, modal
│   └── ai_map.js           # Hartă AI: D3 proiecție, TopoJSON, tooltip, legendă
└── src/
    ├── Controller/         # Validare HTTP, orchestrare răspuns JSON
    ├── Service/            # Logică business, agregări, transformări
    ├── Repository/         # Interogări SQL (PDO prepared statements)
    └── DTO/                # Obiecte transfer date între straturi</code></pre>
    </div>
  </section>

</main>
</body>
</html>
