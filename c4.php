<?php
$isEmbed = isset($_GET['embed']) && $_GET['embed'] === '1';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Diagrame C4 - DrugExplorer</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <style>
    .c4-main {
      max-width: 1100px;
      margin: 0 auto;
      padding: 2rem 1.5rem 4rem;
    }
    .c4-hero { margin-bottom: 1.75rem; }
    .c4-hero h1 { font-size: 1.5rem; font-weight: 800; color: var(--text); margin-bottom: .4rem; }
    .c4-hero p  { font-size: .85rem; color: var(--text-muted); }

    .c4-toc { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.75rem; }
    .c4-toc a {
      display: flex; align-items: center; gap: .4rem;
      padding: .4rem .9rem;
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 999px; font-size: .82rem; font-weight: 600;
      color: var(--text-mid); text-decoration: none;
      transition: background .15s, color .15s, border-color .15s;
    }
    .c4-toc a:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
    .level-num {
      width: 18px; height: 18px; background: var(--primary-light); color: var(--primary);
      border-radius: 4px; font-size: .7rem; font-weight: 800;
      display: inline-flex; align-items: center; justify-content: center;
    }

    .c4-level { margin-bottom: 2rem; }
    .c4-level > .card-header { font-size: .95rem; font-weight: 700; display: flex; align-items: center; gap: .6rem; }
    .level-badge {
      width: 26px; height: 26px; background: var(--primary); color: #fff;
      border-radius: 6px; font-size: .8rem; font-weight: 800;
      display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .c4-desc {
      padding: .7rem 1.25rem; background: var(--primary-light);
      border-bottom: 1px solid #bfdbfe;
      font-size: .82rem; color: var(--text-mid); line-height: 1.6;
    }
    .c4-diagram-wrap {
      padding: 1.5rem 1rem;
      overflow-x: auto;
      display: flex;
      justify-content: center;
      min-height: 200px;
    }
    .c4-diagram-wrap svg { max-width: 100%; height: auto; }

    body.c4-embed {
      background: transparent;
    }
    body.c4-embed .c4-main {
      max-width: 100%;
      padding: .35rem;
    }
    body.c4-embed .c4-hero,
    body.c4-embed .c4-toc {
      display: none;
    }
    body.c4-embed .c4-level {
      margin-bottom: .8rem;
      border: none;
      box-shadow: none;
      background: transparent;
    }
    body.c4-embed .c4-level > .card-header,
    body.c4-embed .c4-desc {
      display: none;
    }
    body.c4-embed .c4-diagram-wrap {
      padding: .25rem;
      min-height: 0;
      border: 1px solid var(--border);
      border-radius: var(--radius-sm);
      background: #fff;
    }
    body.c4-embed .c4-diagram-wrap .mermaid {
      width: 100%;
      display: flex;
      justify-content: center;
    }
    body.c4-embed .c4-diagram-wrap .mermaid svg {
      width: min(1400px, 98%) !important;
      max-width: none;
      height: auto !important;
    }
  </style>
</head>
<body class="<?php echo $isEmbed ? 'c4-embed' : ''; ?>">

<?php if (!$isEmbed): ?>
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
        Înapoi
      </a></li>
      <li><a href="raport.php" class="tab-btn">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Raport
      </a></li>
    </ul>
    <span class="tab-report-link" style="background:var(--primary);border-color:var(--primary);color:#fff;cursor:default;">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V8l-5-5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v5h5"/></svg>
      Diagrame C4
    </span>
  </div>
</nav>
<?php endif; ?>

<main class="c4-main">

  <div class="c4-hero">
    <h1>Diagrame C4 – DrugExplorer</h1>
    <p>Arhitectura sistemului vizualizată pe trei niveluri conform modelului C4 (Simon Brown)</p>
  </div>

  <div class="c4-toc">
    <a href="#l1"><span class="level-num">1</span> Nivel 1 — Context</a>
    <a href="#l2"><span class="level-num">2</span> Nivel 2 — Container</a>
    <a href="#l3"><span class="level-num">3</span> Nivel 3 — Component</a>
  </div>

  <!-- ══ LEVEL 1 ══ -->
  <section class="c4-level card" id="l1">
    <div class="card-header"><span class="level-badge">1</span> Nivel 1 — Context</div>
    <div class="c4-desc">Sistemul DrugExplorer în relație cu utilizatorii și sistemele externe. Nu detaliază tehnologia internă.</div>
    <div class="c4-diagram-wrap">
      <pre class="mermaid">
%%{init:{"theme":"base","themeVariables":{"primaryColor":"#EFF6FF","primaryBorderColor":"#2563EB","primaryTextColor":"#1E293B","lineColor":"#64748B","fontFamily":"Inter, sans-serif","fontSize":"14px"}}}%%
flowchart TD
    V["👤 Vizitator\nFiltrează statistici, exportă date\nvizualizează harta AI"]
    AD["👤 Administrator\nGestionează droguri și categorii\nprin modulul admin securizat"]

    subgraph SYS["  🖥️  DrugExplorer  "]
        DE["DrugExplorer\n─────────────────\nPHP 8.3 · MySQL 8.0 · Apache 2.4\nAplicație web statistici droguri RO"]
    end

    G["☁️ Groq API\nInferență LLM\nLlama 3.3 70B · Meta AI"]
    WA["☁️ world-atlas CDN\nDate geografice\nTopoJSON · Natural Earth 110m"]
    GF["☁️ Google Fonts CDN\nFonturi web\nInter · DM Mono"]

    V  -->|"HTTPS — vizualizare + export"| DE
    AD -->|"HTTPS — autentificare + CRUD"| DE
    DE -->|"HTTPS/JSON — o dată pe 24h"| G
    DE -->|"HTTPS/TopoJSON — la încărcare hartă"| WA
    DE -->|"HTTPS/CSS+WOFF2"| GF

    classDef person  fill:#DBEAFE,stroke:#2563EB,color:#1E3A8A,rx:8
    classDef system  fill:#EFF6FF,stroke:#2563EB,color:#1E293B
    classDef ext     fill:#F1F5F9,stroke:#94A3B8,color:#475569
    class V,AD person
    class DE system
    class G,WA,GF ext
      </pre>
    </div>
  </section>

  <!-- ══ LEVEL 2 ══ -->
  <section class="c4-level card" id="l2">
    <div class="card-header"><span class="level-badge">2</span> Nivel 2 — Container</div>
    <div class="c4-desc">Componentele tehnice principale ale sistemului și modul în care comunică între ele.</div>
    <div class="c4-diagram-wrap">
      <pre class="mermaid">
%%{init:{"theme":"base","themeVariables":{"primaryColor":"#EFF6FF","primaryBorderColor":"#2563EB","primaryTextColor":"#1E293B","lineColor":"#64748B","fontFamily":"Inter, sans-serif","fontSize":"14px"}}}%%
flowchart TD
    V["👤 Vizitator"]
    AD["👤 Administrator"]

    subgraph SYS["  DrugExplorer  "]
        BR["🌐 Browser SPA\n─────────────────\nHTML5 · CSS3 · JS ES2017\nGrafice Canvas · Hartă SVG\nNavigare prin tab-uri fără reload"]
        PHP["⚙️ PHP Server\n─────────────────\nApache 2.4 · PHP 8.3\nAPI AJAX · Export CSV/JSON\nAdmin · Controller–Service–Repository"]
        DB[("🗄️ MySQL Database\n─────────────────\nMySQL 8.0 · utf8mb4_romanian_ci\n23 tabele statistici\n3 tabele cache AI")]
    end

    G["☁️ Groq API\nLlama 3.3 70B"]
    CDN["☁️ CDN-uri externe\nD3.js · TopoJSON\nworld-atlas · Google Fonts"]

    V  -->|"HTTPS"| BR
    AD -->|"HTTPS"| BR
    BR -->|"HTTP GET/POST · JSON\nAJAX fetch()"| PHP
    PHP -->|"PDO · SQL\nRead/Write"| DB
    PHP -->|"HTTPS · JSON\n1× la 24h"| G
    BR -->|"HTTPS\nbiblioteci + date geo"| CDN

    classDef person fill:#DBEAFE,stroke:#2563EB,color:#1E3A8A
    classDef cont   fill:#EFF6FF,stroke:#2563EB,color:#1E293B
    classDef db     fill:#F0FDF4,stroke:#16A34A,color:#14532D
    classDef ext    fill:#F1F5F9,stroke:#94A3B8,color:#475569
    class V,AD person
    class BR,PHP cont
    class DB db
    class G,CDN ext
      </pre>
    </div>
  </section>

  <!-- ══ LEVEL 3 ══ -->
  <section class="c4-level card" id="l3">
    <div class="card-header"><span class="level-badge">3</span> Nivel 3 — Component (PHP Server)</div>
    <div class="c4-desc">Componentele interne ale containerului PHP Server: rutare, straturile Controller / Service / Repository, endpoint-ul AI și modulul admin.</div>
    <div class="c4-diagram-wrap">
      <pre class="mermaid">
%%{init:{"theme":"base","themeVariables":{"primaryColor":"#EFF6FF","primaryBorderColor":"#2563EB","primaryTextColor":"#1E293B","lineColor":"#64748B","fontFamily":"Inter, sans-serif","fontSize":"13px"}}}%%
flowchart LR
    BR["🌐 Browser SPA"]
    DB[("🗄️ MySQL")]
    GROQ["☁️ Groq API"]

    subgraph PHP["  PHP Server  "]
        direction TB

        subgraph ENTRY["Intrare"]
            ROUTER["router.php\nDispatcher AJAX"]
            BASE["_base.php\nintParam · strParam\nrespondError"]
        end

        subgraph CRUD["Flux date statistice"]
            direction TB
            CTRL["Section Controllers ×6\nConfiscari · Condamnari · Urgente\nTratament · Actiuni · Boli"]
            SVC["Section Services ×6\nLogică business · Agregări"]
            REPO["Section Repositories ×6\nPrepared statements PDO"]
        end

        subgraph EXTRA["Componente speciale"]
            direction TB
            EXP["ExportController\nCSV · JSON"]
            FILT["FiltersController\nOpțiuni filtre UI"]
            AI["ai_map_data.php\nCache 24h · Groq · Stale fallback"]
            ADMIN["admin.php\nAutentificare · CSRF · CRUD"]
        end
    end

    BR -->|"AJAX"| ROUTER
    BR -->|"GET"| AI
    BR -->|"GET/POST"| ADMIN

    ROUTER --> BASE
    ROUTER --> EXP
    ROUTER --> FILT
    ROUTER --> CTRL

    CTRL --> SVC
    SVC  --> REPO
    REPO -->|"SQL"| DB

    EXP  -->|"SQL"| DB
    FILT -->|"SQL"| DB
    AI   -->|"SQL"| DB
    AI   -->|"HTTPS"| GROQ
    ADMIN-->|"SQL"| DB

    classDef ext    fill:#F1F5F9,stroke:#94A3B8,color:#475569
    classDef entry  fill:#EFF6FF,stroke:#2563EB,color:#1E293B
    classDef layer  fill:#F0F9FF,stroke:#0EA5E9,color:#0C4A6E
    classDef special fill:#FFF7ED,stroke:#F59E0B,color:#78350F
    classDef db     fill:#F0FDF4,stroke:#16A34A,color:#14532D

    class BR,GROQ ext
    class DB db
    class ROUTER,BASE entry
    class CTRL,SVC,REPO layer
    class EXP,FILT,AI,ADMIN special
      </pre>
    </div>
  </section>

</main>

<script src="https://cdn.jsdelivr.net/npm/mermaid@11/dist/mermaid.min.js"></script>
<script>
  mermaid.initialize({
    startOnLoad: true,
    theme: 'base',
    flowchart: { useMaxWidth: true, htmlLabels: true, curve: 'basis' },
    themeVariables: {
      fontFamily: "'Inter', system-ui, sans-serif",
      fontSize:   '<?php echo $isEmbed ? '18px' : '14px'; ?>',
    }
  });
</script>
</body>
</html>
