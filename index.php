<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Drug Explorer – Statistici Droguri România</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<!-- ── Header ─────────────────────────────────────────── -->
<header class="app-header">
  <div class="app-brand">
    <div class="brand-name">Drug<span>Explorer</span></div>
    <div class="brand-sub">Statistici naționale · Droguri</div>
  </div>
  <div class="header-meta">Date furnizate de ANAD<br>Anul de referință: 2022</div>
</header>

<!-- ── Tab Navigation ─────────────────────────────────── -->
<nav class="tab-nav">
  <ul class="tab-list">
    <li class="tab-item"><button class="tab-btn active" data-section="confiscari">Confiscări</button></li>
    <li class="tab-item"><button class="tab-btn" data-section="condamnari">Condamnări</button></li>
    <li class="tab-item"><button class="tab-btn" data-section="urgente">Urgențe medicale</button></li>
    <li class="tab-item"><button class="tab-btn" data-section="tratament">Tratament</button></li>
    <li class="tab-item"><button class="tab-btn" data-section="actiuni">Prevenire</button></li>
    <li class="tab-item"><button class="tab-btn" data-section="boli">Boli infecțioase</button></li>
  </ul>
</nav>

<!-- ── Content ────────────────────────────────────────── -->
<div class="app-content">

  <!-- Confiscări -->
  <div class="section active" id="sec-confiscari">
    <h1 class="section-title">Confiscări de droguri</h1>
    <div class="card">
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="confiscari">
          <div class="field">
            <label for="conf-drog">Tip drog</label>
            <select id="conf-drog" name="drog_id">
              <option value="">— Toate —</option>
            </select>
          </div>
          <div class="field">
            <label for="conf-an">An</label>
            <input id="conf-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" />
          </div>
          <div class="form-actions">
            <button type="submit">Caută</button>
            <a class="btn-export" data-section="confiscari" data-format="csv" href="#">Export CSV</a>
            <a class="btn-export" data-section="confiscari" data-format="json" href="#">Export JSON</a>
          </div>
        </form>
        <div class="result-area" id="result-confiscari"></div>
      </div>
    </div>
  </div>

  <!-- Condamnări -->
  <div class="section" id="sec-condamnari">
    <h1 class="section-title">Condamnări · profil demografic</h1>
    <div class="card">
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="condamnari">
          <div class="field">
            <label for="cond-an">An</label>
            <input id="cond-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" />
          </div>
          <div class="field">
            <label for="cond-sex">Sex</label>
            <select id="cond-sex" name="sex">
              <option value="">— Ambele —</option>
              <option value="Masculin">Masculin</option>
              <option value="Feminin">Feminin</option>
            </select>
          </div>
          <div class="form-actions">
            <button type="submit">Caută</button>
            <a class="btn-export" data-section="condamnari" data-format="csv" href="#">Export CSV</a>
            <a class="btn-export" data-section="condamnari" data-format="json" href="#">Export JSON</a>
          </div>
        </form>
        <div class="result-area" id="result-condamnari"></div>
      </div>
    </div>
  </div>

  <!-- Urgențe -->
  <div class="section" id="sec-urgente">
    <h1 class="section-title">Urgențe medicale · detalii pe sex</h1>
    <div class="card">
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="urgente">
          <div class="field">
            <label for="urg-cat">Categorie drog</label>
            <select id="urg-cat" name="categorie_id">
              <option value="">— Toate —</option>
            </select>
          </div>
          <div class="field">
            <label for="urg-an">An</label>
            <input id="urg-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" />
          </div>
          <div class="form-actions">
            <button type="submit">Caută</button>
            <a class="btn-export" data-section="urgente" data-format="csv" href="#">Export CSV</a>
            <a class="btn-export" data-section="urgente" data-format="json" href="#">Export JSON</a>
          </div>
        </form>
        <div class="result-area" id="result-urgente"></div>
      </div>
    </div>
  </div>

  <!-- Tratament -->
  <div class="section" id="sec-tratament">
    <h1 class="section-title">Regim de tratament</h1>
    <div class="card">
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="tratament">
          <div class="field">
            <label for="trat-cat">Categorie drog</label>
            <select id="trat-cat" name="categorie_id">
              <option value="">— Toate —</option>
            </select>
          </div>
          <div class="field">
            <label for="trat-an">An</label>
            <input id="trat-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" />
          </div>
          <div class="form-actions">
            <button type="submit">Caută</button>
            <a class="btn-export" data-section="tratament" data-format="csv" href="#">Export CSV</a>
            <a class="btn-export" data-section="tratament" data-format="json" href="#">Export JSON</a>
          </div>
        </form>
        <div class="result-area" id="result-tratament"></div>
      </div>
    </div>
  </div>

  <!-- Prevenire -->
  <div class="section" id="sec-actiuni">
    <h1 class="section-title">Proiecte de prevenire</h1>
    <div class="card">
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="actiuni">
          <div class="field">
            <label for="act-an">An</label>
            <input id="act-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022" />
          </div>
          <div class="form-actions">
            <button type="submit">Caută</button>
            <a class="btn-export" data-section="actiuni" data-format="csv" href="#">Export CSV</a>
            <a class="btn-export" data-section="actiuni" data-format="json" href="#">Export JSON</a>
          </div>
        </form>
        <div class="result-area" id="result-actiuni"></div>
      </div>
    </div>
  </div>

  <!-- Boli -->
  <div class="section" id="sec-boli">
    <h1 class="section-title">Prevalența bolilor infecțioase · pe sex</h1>
    <div class="card">
      <div class="card-body">
        <form class="ajax-form" data-endpoint="api/router.php" data-section="boli">
          <div class="field">
            <label for="boala-sel">Boală</label>
            <select id="boala-sel" name="boala_id">
              <option value="">— Toate —</option>
            </select>
          </div>
          <div class="form-actions">
            <button type="submit">Caută</button>
            <a class="btn-export" data-section="boli" data-format="csv" href="#">Export CSV</a>
            <a class="btn-export" data-section="boli" data-format="json" href="#">Export JSON</a>
          </div>
        </form>
        <div class="result-area" id="result-boli"></div>
      </div>
    </div>
  </div>

</div><!-- /.app-content -->

<script src="js/app.js"></script>
</body>
</html>