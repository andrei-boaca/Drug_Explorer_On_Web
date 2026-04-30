<?php
// Returnează listele pentru dropdown-uri (tipuri droguri, categorii, boli)
require_once __DIR__ . '/_base.php';

respond([
    'droguri'   => q('SELECT id, nume AS label FROM tipuri_droguri ORDER BY nume'),
    'categorii' => q('SELECT id, nume AS label FROM categorii_droguri ORDER BY nume'),
    'boli'      => q('SELECT id, nume AS label FROM boli ORDER BY nume'),
]);
