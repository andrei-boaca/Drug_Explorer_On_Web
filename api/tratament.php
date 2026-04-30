<?php
require_once __DIR__ . '/_base.php';

$p = []; $w = [];

$cat_id = intParam('categorie_id');
$an     = intParam('an');

if ($cat_id !== null) { $w[] = 'r.id_categorie = ?'; $p[] = $cat_id; }
if ($an     !== null) { $w[] = 'r.an = ?';           $p[] = $an; }

$where = $w ? 'WHERE ' . implode(' AND ', $w) : '';

$rows = q("SELECT cat.nume AS categorie, r.regim, r.nr_pacienti, r.an
           FROM regim_tratament r
           JOIN categorii_droguri cat ON cat.id = r.id_categorie
           $where
           ORDER BY r.an, cat.nume, r.regim", $p);

respond(['data' => $rows, 'total' => count($rows)]);
