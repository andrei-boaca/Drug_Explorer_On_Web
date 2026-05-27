<?php
session_start();
require_once __DIR__ . '/config.php';

// IMPORTANT: schimbă parola înainte de deployment în producție!
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

function verifyCsrf(): void {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Token CSRF invalid. Reîncarcă pagina.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Autentificare
    if ($action === 'login') {
        if (($_POST['username'] ?? '') === ADMIN_USER && ($_POST['password'] ?? '') === ADMIN_PASS) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['flash'] = ['type' => 'ok', 'msg' => 'Autentificare reușită. Bine ai venit!'];
        } else {
            $_SESSION['flash'] = ['type' => 'err', 'msg' => 'Nume de utilizator sau parolă incorecte.'];
        }
        header('Location: admin.php'); exit;
    }

    // Deconectare
    if ($action === 'logout') {
        session_destroy();
        header('Location: admin.php'); exit;
    }

    // Operatiuni CRUD — necesita sesiune activa + token CSRF valid
    if (!empty($_SESSION['admin_logged_in'])) {
        verifyCsrf();
        $pdo = getConnection();
        try {
            switch ($action) {

                case 'add_drug':
                    $name  = trim($_POST['name'] ?? '');
                    $catId = intval($_POST['cat_id'] ?? 0) ?: null;
                    if ($name === '') throw new RuntimeException('Numele drogului este obligatoriu.');
                    $pdo->prepare('INSERT INTO tipuri_droguri (nume, id_categorie) VALUES (?, ?)')->execute([$name, $catId]);
                    $_SESSION['flash'] = ['type' => 'ok', 'msg' => "Drogul „{$name}\" a fost adăugat cu succes."];
                    break;

                case 'delete_drug':
                    $id   = intval($_POST['id']);
                    $stmt = $pdo->prepare('SELECT nume FROM tipuri_droguri WHERE id = ?');
                    $stmt->execute([$id]);
                    $name = $stmt->fetchColumn() ?: 'necunoscut';
                    $pdo->prepare('DELETE FROM tipuri_droguri WHERE id = ?')->execute([$id]);
                    $_SESSION['flash'] = ['type' => 'ok', 'msg' => "Drogul „{$name}\" a fost șters."];
                    break;

                case 'add_category':
                    $name = trim($_POST['name'] ?? '');
                    if ($name === '') throw new RuntimeException('Numele categoriei este obligatoriu.');
                    $pdo->prepare('INSERT INTO categorii_droguri (nume) VALUES (?)')->execute([$name]);
                    $_SESSION['flash'] = ['type' => 'ok', 'msg' => "Categoria „{$name}\" a fost adăugată cu succes."];
                    break;

                case 'delete_category':
                    $id   = intval($_POST['id']);
                    $stmt = $pdo->prepare('SELECT nume FROM categorii_droguri WHERE id = ?');
                    $stmt->execute([$id]);
                    $name = $stmt->fetchColumn() ?: 'necunoscută';
                    $pdo->prepare('DELETE FROM categorii_droguri WHERE id = ?')->execute([$id]);
                    $_SESSION['flash'] = ['type' => 'ok', 'msg' => "Categoria „{$name}\" a fost ștearsă."];
                    break;

                default:
                    throw new RuntimeException('Acțiune necunoscută.');
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'err', 'msg' => htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')];
        }
        header('Location: admin.php'); exit;
    }
}

$isLoggedIn = !empty($_SESSION['admin_logged_in']);
$flash      = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$drugs = $categories = $stats = [];
if ($isLoggedIn) {
    $pdo = getConnection();
    $drugs = $pdo->query(
        'SELECT t.id, t.nume, COALESCE(c.nume, \'\') AS categorie
         FROM tipuri_droguri t
         LEFT JOIN categorii_droguri c ON c.id = t.id_categorie
         ORDER BY t.nume'
    )->fetchAll();
    $categories = $pdo->query('SELECT * FROM categorii_droguri ORDER BY nume')->fetchAll();
    $stats = [
        ['label' => 'Tipuri droguri',  'val' => count($drugs)],
        ['label' => 'Categorii',       'val' => count($categories)],
        ['label' => 'Confiscari',      'val' => $pdo->query('SELECT COUNT(*) FROM confiscari')->fetchColumn()],
        ['label' => 'Condamnari',      'val' => $pdo->query('SELECT COUNT(*) FROM condamnari')->fetchColumn()],
        ['label' => 'Urgente',         'val' => $pdo->query('SELECT COUNT(*) FROM sex_urgente')->fetchColumn()],
        ['label' => 'Tratament',       'val' => $pdo->query('SELECT COUNT(*) FROM regim_tratament')->fetchColumn()],
        ['label' => 'Actiuni',         'val' => $pdo->query('SELECT COUNT(*) FROM actiuni')->fetchColumn()],
        ['label' => 'Boli',            'val' => $pdo->query('SELECT COUNT(*) FROM prevalenta_sex')->fetchColumn()],
    ];
}

function esc(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – DrugExplorer</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Inter', system-ui, sans-serif; background: #F1F5F9; color: #1E293B; font-size: 14px; }
    a { color: #2563EB; text-decoration: none; }
    a:hover { text-decoration: underline; }

    .adm-header {
      background: #1E293B; color: #fff;
      padding: 0 2rem;
      display: flex; align-items: center; justify-content: space-between;
      height: 52px;
      position: sticky; top: 0; z-index: 100;
    }
    .adm-header .brand { font-weight: 700; font-size: 1rem; letter-spacing: .5px; }
    .adm-header .brand span { color: #3B82F6; }
    .adm-header form button {
      background: none; border: 1px solid rgba(255,255,255,.35); color: #fff;
      padding: .35rem .85rem; border-radius: 6px; cursor: pointer; font-size: .8rem;
    }
    .adm-header form button:hover { background: rgba(255,255,255,.1); }

    .adm-main { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem 4rem; }

    .flash {
      padding: .75rem 1rem; border-radius: 8px; margin-bottom: 1.25rem;
      font-size: .875rem; font-weight: 500;
    }
    .flash.ok  { background: #DCFCE7; color: #166534; border: 1px solid #86EFAC; }
    .flash.err { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }

    .login-wrap { display: flex; align-items: center; justify-content: center; min-height: calc(100vh - 52px); }
    .login-card {
      background: #fff; border: 1px solid #E2E8F0;
      border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,.08);
      padding: 2.5rem 2rem; width: 340px;
    }
    .login-card h1 { font-size: 1.3rem; margin-bottom: 1.5rem; text-align: center; }
    .login-card label { display: block; font-size: .8rem; font-weight: 600; color: #64748B; margin-bottom: .35rem; }
    .login-card input[type="text"],
    .login-card input[type="password"] {
      width: 100%; padding: .55rem .8rem; border: 1px solid #CBD5E1;
      border-radius: 7px; font-size: .9rem; margin-bottom: 1rem;
      transition: border .15s;
    }
    .login-card input:focus { outline: none; border-color: #2563EB; }
    .login-card .btn-login {
      width: 100%; padding: .65rem; background: #2563EB; color: #fff;
      border: none; border-radius: 7px; font-size: .9rem; font-weight: 600;
      cursor: pointer; transition: background .15s;
    }
    .login-card .btn-login:hover { background: #1D4ED8; }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: .75rem; margin-bottom: 2rem; }
    .stat-tile {
      background: #fff; border: 1px solid #E2E8F0; border-radius: 10px;
      padding: 1rem; text-align: center;
    }
    .stat-tile .num { font-size: 1.6rem; font-weight: 700; color: #2563EB; }
    .stat-tile .lbl { font-size: .75rem; color: #64748B; margin-top: .2rem; }

    .adm-card {
      background: #fff; border: 1px solid #E2E8F0; border-radius: 10px;
      box-shadow: 0 1px 4px rgba(0,0,0,.04);
      margin-bottom: 2rem; overflow: hidden;
    }
    .adm-card-title {
      padding: .8rem 1.25rem; background: #F8FAFC;
      border-bottom: 1px solid #E2E8F0;
      font-weight: 600; font-size: .9rem; color: #334155;
    }
    .adm-card-body { padding: 1.25rem; }

    .add-form { display: flex; gap: .75rem; flex-wrap: wrap; margin-bottom: 1.25rem; align-items: flex-end; }
    .add-form label { font-size: .78rem; font-weight: 600; color: #64748B; display: block; margin-bottom: .3rem; }
    .add-form input[type="text"],
    .add-form select {
      padding: .5rem .75rem; border: 1px solid #CBD5E1; border-radius: 7px;
      font-size: .875rem; min-width: 200px;
    }
    .add-form input:focus, .add-form select:focus { outline: none; border-color: #2563EB; }
    .btn-add {
      padding: .5rem 1.1rem; background: #2563EB; color: #fff;
      border: none; border-radius: 7px; font-size: .875rem; font-weight: 600;
      cursor: pointer; white-space: nowrap;
    }
    .btn-add:hover { background: #1D4ED8; }

    .adm-table { width: 100%; border-collapse: collapse; font-size: .86rem; }
    .adm-table th {
      text-align: left; padding: .55rem .8rem;
      background: #F8FAFC; color: #64748B; font-weight: 600;
      border-bottom: 1px solid #E2E8F0;
    }
    .adm-table td { padding: .5rem .8rem; border-bottom: 1px solid #F1F5F9; }
    .adm-table tr:last-child td { border-bottom: none; }
    .adm-table tr:hover td { background: #F8FAFC; }
    .btn-del {
      padding: .3rem .7rem; background: #FEE2E2; color: #B91C1C;
      border: 1px solid #FCA5A5; border-radius: 5px; font-size: .78rem;
      cursor: pointer; font-weight: 600;
    }
    .btn-del:hover { background: #FCA5A5; }
    .badge-cat {
      display: inline-block; padding: .15rem .55rem;
      background: #EFF6FF; color: #1D4ED8;
      border-radius: 20px; font-size: .75rem;
    }
    .empty-note { color: #94A3B8; font-style: italic; font-size: .875rem; text-align: center; padding: 1.5rem 0; }

    @media (max-width: 600px) {
      .adm-main { padding: 0 1rem 3rem; }
      .add-form { flex-direction: column; }
      .add-form input[type="text"], .add-form select { min-width: 0; width: 100%; }
    }
  </style>
</head>
<body>

<header class="adm-header">
  <div class="brand">Drug<span>Explorer</span> &mdash; Admin</div>
  <?php if ($isLoggedIn): ?>
  <form method="POST" action="admin.php">
    <input type="hidden" name="action" value="logout" />
    <button type="submit">Deconectare</button>
  </form>
  <?php endif; ?>
</header>

<main class="adm-main">

  <?php if ($flash): ?>
  <div class="flash <?= $flash['type'] === 'ok' ? 'ok' : 'err' ?>">
    <?= $flash['msg'] ?>
  </div>
  <?php endif; ?>

  <?php if (!$isLoggedIn): ?>
  <div class="login-wrap">
    <div class="login-card">
      <h1>Autentificare Admin</h1>
      <form method="POST" action="admin.php">
        <input type="hidden" name="action" value="login" />
        <label for="username">Utilizator</label>
        <input type="text" id="username" name="username" autocomplete="username" required />
        <label for="password">Parolă</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required />
        <button type="submit" class="btn-login">Intră în panou</button>
      </form>
      <p style="text-align:center;margin-top:1.25rem;font-size:.8rem;color:#94A3B8;">
        <a href="index.php">← Înapoi la aplicație</a>
      </p>
    </div>
  </div>

  <?php else: ?>

  <h2 style="margin-bottom:1.25rem;font-size:1.25rem;color:#1E293B;">
    Panou de administrare
    <a href="index.php" style="font-size:.8rem;font-weight:400;margin-left:1rem;color:#64748B;">← Înapoi la aplicație</a>
  </h2>

  <div class="stats-grid">
    <?php foreach ($stats as $s): ?>
    <div class="stat-tile">
      <div class="num"><?= intval($s['val']) ?></div>
      <div class="lbl"><?= esc($s['label']) ?></div>
    </div>
    <?php endforeach; ?>
  </div>

  <div class="adm-card">
    <div class="adm-card-title">Tipuri de droguri</div>
    <div class="adm-card-body">
      <form method="POST" action="admin.php" class="add-form">
        <input type="hidden" name="action" value="add_drug" />
        <input type="hidden" name="csrf_token" value="<?= esc($_SESSION['csrf_token']) ?>" />
        <div>
          <label for="drug_name">Nume drog</label>
          <input type="text" id="drug_name" name="name" placeholder="ex: Heroina" maxlength="255" required />
        </div>
        <div>
          <label for="drug_cat">Categorie</label>
          <select id="drug_cat" name="cat_id">
            <option value="">— fără categorie —</option>
            <?php foreach ($categories as $c): ?>
            <option value="<?= intval($c['id']) ?>"><?= esc($c['nume']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label style="visibility:hidden">.</label>
          <button type="submit" class="btn-add">+ Adaugă drog</button>
        </div>
      </form>

      <?php if (empty($drugs)): ?>
      <p class="empty-note">Nu există tipuri de droguri înregistrate.</p>
      <?php else: ?>
      <table class="adm-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nume</th>
            <th>Categorie</th>
            <th>Acțiuni</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($drugs as $i => $d): ?>
          <tr>
            <td style="color:#94A3B8"><?= $i + 1 ?></td>
            <td><?= esc($d['nume']) ?></td>
            <td>
              <?php if ($d['categorie'] !== ''): ?>
              <span class="badge-cat"><?= esc($d['categorie']) ?></span>
              <?php else: ?>
              <span style="color:#CBD5E1">—</span>
              <?php endif; ?>
            </td>
            <td>
              <form method="POST" action="admin.php" style="display:inline"
                    onsubmit="return confirm('Ștergi drogul „<?= esc(addslashes($d['nume'])) ?>"?');">
                <input type="hidden" name="action"     value="delete_drug" />
                <input type="hidden" name="id"         value="<?= intval($d['id']) ?>" />
                <input type="hidden" name="csrf_token" value="<?= esc($_SESSION['csrf_token']) ?>" />
                <button type="submit" class="btn-del">Șterge</button>
              </form>
            </td>
        
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </div>

  <div class="adm-card">
    <div class="adm-card-title">Categorii de droguri</div>
    <div class="adm-card-body">
      <form method="POST" action="admin.php" class="add-form">
        <input type="hidden" name="action" value="add_category" />
        <input type="hidden" name="csrf_token" value="<?= esc($_SESSION['csrf_token']) ?>" />
        <div>
          <label for="cat_name">Nume categorie</label>
          <input type="text" id="cat_name" name="name" placeholder="ex: Opiacee" maxlength="255" required />
        </div>
        <div>
          <label style="visibility:hidden">.</label>
          <button type="submit" class="btn-add">+ Adaugă categorie</button>
        </div>
      </form>

      <?php if (empty($categories)): ?>
      <p class="empty-note">Nu există categorii înregistrate.</p>
      <?php else: ?>
      <table class="adm-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Categorie</th>
            <th>Nr. droguri</th>
            <th>Acțiuni</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $i => $c): ?>
          <?php $cnt = count(array_filter($drugs, fn($d) => $d['categorie'] === $c['nume'])); ?>
          <tr>
            <td style="color:#94A3B8"><?= $i + 1 ?></td>
            <td><?= esc($c['nume']) ?></td>
            <td style="color:#64748B"><?= $cnt ?></td>
            <td>
              <form method="POST" action="admin.php" style="display:inline"
                    onsubmit="return confirm('Ștergi categoria „<?= esc(addslashes($c['nume'])) ?>"? Toate drogurile asociate vor fi șterse.');">
                <input type="hidden" name="action"     value="delete_category" />
                <input type="hidden" name="id"         value="<?= intval($c['id']) ?>" />
                <input type="hidden" name="csrf_token" value="<?= esc($_SESSION['csrf_token']) ?>" />
                <button type="submit" class="btn-del">Șterge</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </div>

  <?php endif; ?>
</main>
</body>
</html>
