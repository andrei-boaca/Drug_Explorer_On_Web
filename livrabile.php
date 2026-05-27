<?php
$allowedPages = ['raport', 'video', 'c4'];
$page = $_GET['page'] ?? 'raport';

if (!in_array($page, $allowedPages, true)) {
        $page = 'raport';
}
?><!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DrugExplorer - Livrabile</title>
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
        <a href="index.php" class="header-admin-link">Inapoi la aplicatie</a>
    </div>
    <div class="ro-stripe"><div></div><div></div><div></div></div>
</header>

<nav class="tab-nav">
    <div class="tab-inner">
        <ul class="tab-list">
            <li><a href="?page=raport" class="tab-btn <?php echo $page === 'raport' ? 'active' : ''; ?>">Raport</a></li>
            <li><a href="?page=video" class="tab-btn <?php echo $page === 'video' ? 'active' : ''; ?>">Videoclip</a></li>
            <li><a href="?page=c4" class="tab-btn <?php echo $page === 'c4' ? 'active' : ''; ?>">Diagrama C4</a></li>
        </ul>
    </div>
</nav>

<main class="app-main livrabile-main">
    <section class="section active">
        <div class="section-header">
            <h1 class="section-title">Livrabile proiect</h1>
            <p class="section-desc">Selecteaza livrabilul pe care vrei sa il vizualizezi.</p>
        </div>

        <?php if ($page === 'raport'): ?>
            <div class="card livrabile-card">
                <div class="card-header">Raport tehnic</div>
                <div class="card-body">
                    <div class="livrabile-actions">
                        <a class="btn-export" href="raport.php" target="_blank" rel="noopener noreferrer">Deschide in pagina separata</a>
                    </div>
                    <div class="livrabile-frame-wrap">
                        <iframe class="livrabile-frame" src="raport.php" title="Raport tehnic DrugExplorer"></iframe>
                    </div>
                </div>
            </div>
        <?php elseif ($page === 'video'): ?>
            <div class="card livrabile-card">
                <div class="card-header">Videoclip de prezentare</div>
                <div class="card-body">
                    <p class="livrabile-note">Clipul de prezentare al proiectului este disponibil mai jos.</p>
                    <div class="livrabile-video-wrap">
                        <iframe class="livrabile-video" src="https://drive.google.com/file/d/1iPaulrJ-1n4VwbdhAQU7YhkKvXzVV6eh/preview" title="Videoclip prezentare" allow="autoplay; fullscreen" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="card livrabile-card">
                <div class="card-header">Diagrama C4</div>
                <div class="card-body">
                    <div class="livrabile-actions">
                        <a class="btn-export" href="c4.php" target="_blank" rel="noopener noreferrer">Deschide in pagina separata</a>
                    </div>
                    <div class="livrabile-frame-wrap">
                        <iframe class="livrabile-frame livrabile-frame-c4" src="c4.php?embed=1" title="Diagrama C4 DrugExplorer"></iframe>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
