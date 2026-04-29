<?php
require_once __DIR__ . '/config.php';



function q(string $sql, array $params = []): array {
    try {
        $stmt = getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log('DB: ' . $e->getMessage());
        return [];
    }
}

function renderSelect(string $id, string $name, array $rows, string $placeholder, string $current = ''): string {
    $html = "<select id=\"$id\" name=\"$name\"><option value=\"\">$placeholder</option>";
    foreach ($rows as $row) {
        $selected = ((string)$current === (string)$row['id']) ? ' selected' : '';
        $html .= '<option value="' . (int)$row['id'] . "\"$selected>" . htmlspecialchars($row['label']) . '</option>';
    }
    return $html . '</select>';
}

function renderTable(array $rows, array $cols): string {
    if (!$rows) {
        return '<p class="empty">Niciun rezultat găsit.</p>';
    }
    $ths = implode('', array_map(fn($c) => '<th>' . $c['label'] . '</th>', $cols));
    $trs = '';
    foreach ($rows as $row) {
        $tds = '';
        foreach ($cols as $c) {
            $val = $row[$c['key']] ?? '—';
            if (isset($c['badge'])) {
                $cls = $c['badge'][$val] ?? '';
                $tds .= '<td><span class="badge ' . $cls . '">' . htmlspecialchars((string)$val) . '</span></td>';
            } else {
                $tds .= '<td>' . htmlspecialchars((string)$val) . '</td>';
            }
        }
        $trs .= "<tr>$tds</tr>";
    }
    return "<table><thead><tr>$ths</tr></thead><tbody>$trs</tbody></table>";
}


$droguri   = q('SELECT id, nume AS label FROM tipuri_droguri ORDER BY nume');
$categorii = q('SELECT id, nume AS label FROM categorii_droguri ORDER BY nume');
$boli_list = q('SELECT id, nume AS label FROM boli ORDER BY nume');


$sec     = $_GET['section'] ?? '';
$results = null;

if ($sec === 'confiscari') {
    $p = []; $w = [];
    if (!empty($_GET['drog_id'])) { $w[] = 'c.id_drog = ?'; $p[] = (int)$_GET['drog_id']; }
    if (!empty($_GET['an']))      { $w[] = 'c.an = ?';      $p[] = (int)$_GET['an']; }
    $where   = $w ? 'WHERE ' . implode(' AND ', $w) : '';
    $results = q("SELECT t.nume AS drog, c.grame, c.comprimate, c.doze,
                         c.mililitri, c.nr_capturi, c.an
                  FROM confiscari c
                  JOIN tipuri_droguri t ON t.id = c.id_drog
                  $where ORDER BY c.an, t.nume", $p);
}

if ($sec === 'condamnari') {
    $p = []; $w = [];
    if (!empty($_GET['an'])) { $w[] = 'an = ?'; $p[] = (int)$_GET['an']; }
    if (!empty($_GET['sex']) && in_array($_GET['sex'], ['Masculin', 'Feminin'], true)) {
        $w[] = 'sex = ?'; $p[] = $_GET['sex'];
    }
    $where   = $w ? 'WHERE ' . implode(' AND ', $w) : '';
    $results = q("SELECT numar, sex,
                         CASE WHEN minor = 1 THEN 'Minor' ELSE 'Major' END AS varsta_grup,
                         an
                  FROM condamnari $where ORDER BY an, sex, minor", $p);
}

if ($sec === 'urgente') {
    $p = []; $w = [];
    if (!empty($_GET['categorie_id'])) { $w[] = 'u.id_categorie = ?'; $p[] = (int)$_GET['categorie_id']; }
    if (!empty($_GET['an']))           { $w[] = 'u.an = ?';           $p[] = (int)$_GET['an']; }
    $where   = $w ? 'WHERE ' . implode(' AND ', $w) : '';
    $results = q("SELECT cat.nume AS categorie, u.sex, u.nr_pacienti, u.an
                  FROM sex_urgente u
                  JOIN categorii_droguri cat ON cat.id = u.id_categorie
                  $where ORDER BY u.an, cat.nume, u.sex", $p);
}

if ($sec === 'tratament') {
    $p = []; $w = [];
    if (!empty($_GET['categorie_id'])) { $w[] = 'r.id_categorie = ?'; $p[] = (int)$_GET['categorie_id']; }
    if (!empty($_GET['an']))           { $w[] = 'r.an = ?';           $p[] = (int)$_GET['an']; }
    $where   = $w ? 'WHERE ' . implode(' AND ', $w) : '';
    $results = q("SELECT cat.nume AS categorie, r.regim, r.nr_pacienti, r.an
                  FROM regim_tratament r
                  JOIN categorii_droguri cat ON cat.id = r.id_categorie
                  $where ORDER BY r.an, cat.nume, r.regim", $p);
}

if ($sec === 'actiuni') {
    $p = []; $w = [];
    if (!empty($_GET['an'])) { $w[] = 'a.an = ?'; $p[] = (int)$_GET['an']; }
    $where   = $w ? 'WHERE ' . implode(' AND ', $w) : '';
    $results = q("SELECT p.nume AS proiect, a.nr_beneficiari, a.an
                  FROM actiuni a
                  JOIN proiecte p ON p.id = a.id_proiect
                  $where ORDER BY a.an, a.nr_beneficiari DESC", $p);
}

if ($sec === 'boli') {
    $p = []; $w = [];
    if (!empty($_GET['boala_id'])) { $w[] = 'ps.id_boala = ?'; $p[] = (int)$_GET['boala_id']; }
    $where   = $w ? 'WHERE ' . implode(' AND ', $w) : '';
    $results = q("SELECT b.nume AS boala, ps.sex, ps.nr_testati, ps.nr_pozitivi,
                         ROUND(ps.nr_pozitivi * 100.0 / NULLIF(ps.nr_testati, 0), 1) AS rata_pozitivi
                  FROM prevalenta_sex ps
                  JOIN boli b ON b.id = ps.id_boala
                  $where ORDER BY b.nume, ps.sex", $p);
}

$sexBadge = ['Masculin' => 'badge-m', 'Feminin' => 'badge-f'];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Drug Explorer – Statistici Droguri România</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<main>

  <!-- ================================================================
       FORM 1 – Confiscări
       ================================================================ -->
  <div class="card">
    <div class="card-header">
      <h2>Confiscări de droguri</h2>
    </div>
    <div class="card-body">
      <form method="get" action="">
        <input type="hidden" name="section" value="confiscari" />
        <div class="field">
          <label for="conf-drog">Tip drog</label>
          <?= renderSelect('conf-drog', 'drog_id', $droguri, '— Toate —', $_GET['drog_id'] ?? '') ?>
        </div>
        <div class="field">
          <label for="conf-an">An</label>
          <input id="conf-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022"
                 value="<?= htmlspecialchars($_GET['an'] ?? '') ?>" />
        </div>
        <button type="submit">Caută</button>
      </form>
      <?php if ($sec === 'confiscari'): ?>
      <div class="result-area">
        <?= renderTable($results, [
          ['key' => 'drog',       'label' => 'Drog'],
          ['key' => 'grame',      'label' => 'Grame'],
          ['key' => 'comprimate', 'label' => 'Comprimate'],
          ['key' => 'doze',       'label' => 'Doze'],
          ['key' => 'mililitri',  'label' => 'mL'],
          ['key' => 'nr_capturi', 'label' => 'Nr. capturi'],
          ['key' => 'an',         'label' => 'An'],
        ]) ?>
      </div>
      <?php endif ?>
    </div>
  </div>

  <!-- ================================================================
       FORM 2 – Condamnări
       ================================================================ -->
  <div class="card">
    <div class="card-header">
      <h2>Condamnări (profil demografic)</h2>
    </div>
    <div class="card-body">
      <form method="get" action="">
        <input type="hidden" name="section" value="condamnari" />
        <div class="field">
          <label for="cond-an">An</label>
          <input id="cond-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022"
                 value="<?= htmlspecialchars($_GET['an'] ?? '') ?>" />
        </div>
        <div class="field">
          <label for="cond-sex">Sex</label>
          <select id="cond-sex" name="sex">
            <option value="">— Ambele —</option>
            <option value="Masculin" <?= (($_GET['sex'] ?? '') === 'Masculin') ? 'selected' : '' ?>>Masculin</option>
            <option value="Feminin"  <?= (($_GET['sex'] ?? '') === 'Feminin')  ? 'selected' : '' ?>>Feminin</option>
          </select>
        </div>
        <button type="submit">Caută</button>
      </form>
      <?php if ($sec === 'condamnari'): ?>
      <div class="result-area">
        <?= renderTable($results, [
          ['key' => 'numar',       'label' => 'Nr. condamnați'],
          ['key' => 'sex',         'label' => 'Sex',        'badge' => $sexBadge],
          ['key' => 'varsta_grup', 'label' => 'Grup vârstă','badge' => ['Minor' => 'badge-minor', 'Major' => 'badge-major']],
          ['key' => 'an',          'label' => 'An'],
        ]) ?>
      </div>
      <?php endif ?>
    </div>
  </div>

  <!-- ================================================================
       FORM 3 – Urgențe medicale
       ================================================================ -->
  <div class="card">
    <div class="card-header">
      <h2>Urgențe medicale – detalii pe sex</h2>
    </div>
    <div class="card-body">
      <form method="get" action="">
        <input type="hidden" name="section" value="urgente" />
        <div class="field">
          <label for="urg-cat">Categorie drog</label>
          <?= renderSelect('urg-cat', 'categorie_id', $categorii, '— Toate —', $_GET['categorie_id'] ?? '') ?>
        </div>
        <div class="field">
          <label for="urg-an">An</label>
          <input id="urg-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022"
                 value="<?= htmlspecialchars($_GET['an'] ?? '') ?>" />
        </div>
        <button type="submit">Caută</button>
      </form>
      <?php if ($sec === 'urgente'): ?>
      <div class="result-area">
        <?= renderTable($results, [
          ['key' => 'categorie',   'label' => 'Categorie drog'],
          ['key' => 'sex',         'label' => 'Sex', 'badge' => $sexBadge],
          ['key' => 'nr_pacienti', 'label' => 'Nr. pacienți'],
          ['key' => 'an',          'label' => 'An'],
        ]) ?>
      </div>
      <?php endif ?>
    </div>
  </div>

  <!-- ================================================================
       FORM 4 – Regim de tratament
       ================================================================ -->
  <div class="card">
    <div class="card-header">
      <h2>Regim de tratament</h2>
    </div>
    <div class="card-body">
      <form method="get" action="">
        <input type="hidden" name="section" value="tratament" />
        <div class="field">
          <label for="trat-cat">Categorie drog</label>
          <?= renderSelect('trat-cat', 'categorie_id', $categorii, '— Toate —', $_GET['categorie_id'] ?? '') ?>
        </div>
        <div class="field">
          <label for="trat-an">An</label>
          <input id="trat-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022"
                 value="<?= htmlspecialchars($_GET['an'] ?? '') ?>" />
        </div>
        <button type="submit">Caută</button>
      </form>
      <?php if ($sec === 'tratament'): ?>
      <div class="result-area">
        <?= renderTable($results, [
          ['key' => 'categorie',   'label' => 'Categorie drog'],
          ['key' => 'regim',       'label' => 'Regim'],
          ['key' => 'nr_pacienti', 'label' => 'Nr. pacienți'],
          ['key' => 'an',          'label' => 'An'],
        ]) ?>
      </div>
      <?php endif ?>
    </div>
  </div>

  <!-- ================================================================
       FORM 5 – Proiecte de prevenire
       ================================================================ -->
  <div class="card">
    <div class="card-header">
      <h2>Proiecte de prevenire</h2>
    </div>
    <div class="card-body">
      <form method="get" action="">
        <input type="hidden" name="section" value="actiuni" />
        <div class="field">
          <label for="act-an">An</label>
          <input id="act-an" name="an" type="number" min="2000" max="2030" placeholder="ex. 2022"
                 value="<?= htmlspecialchars($_GET['an'] ?? '') ?>" />
        </div>
        <button type="submit">Caută</button>
      </form>
      <?php if ($sec === 'actiuni'): ?>
      <div class="result-area">
        <?= renderTable($results, [
          ['key' => 'proiect',        'label' => 'Proiect'],
          ['key' => 'nr_beneficiari', 'label' => 'Nr. beneficiari'],
          ['key' => 'an',             'label' => 'An'],
        ]) ?>
      </div>
      <?php endif ?>
    </div>
  </div>

  <!-- ================================================================
       FORM 6 – Boli infecțioase
       ================================================================ -->
  <div class="card">
    <div class="card-header">
      <span class="icon"></span>
      <h2>Prevalența bolilor infecțioase (pe sex)</h2>
    </div>
    <div class="card-body">
      <form method="get" action="">
        <input type="hidden" name="section" value="boli" />
        <div class="field">
          <label for="boala-sel">Boală</label>
          <?= renderSelect('boala-sel', 'boala_id', $boli_list, '— Toate —', $_GET['boala_id'] ?? '') ?>
        </div>
        <button type="submit">Caută</button>
      </form>
      <?php if ($sec === 'boli'): ?>
      <div class="result-area">
        <?= renderTable($results, [
          ['key' => 'boala',         'label' => 'Boală'],
          ['key' => 'sex',           'label' => 'Sex', 'badge' => $sexBadge],
          ['key' => 'nr_testati',    'label' => 'Testați'],
          ['key' => 'nr_pozitivi',   'label' => 'Pozitivi'],
          ['key' => 'rata_pozitivi', 'label' => 'Rată pozitivi (%)'],
        ]) ?>
      </div>
      <?php endif ?>
    </div>
  </div>

</main>

</body>
</html>
