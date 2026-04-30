<?php
require_once __DIR__ . '/_base.php';

$p = []; $w = [];

$cat_id = intParam('categorie_id');
$an     = intParam('an');

if ($cat_id !== null) { $w[] = 'u.id_categorie = ?'; $p[] = $cat_id; }
if ($an     !== null) { $w[] = 'u.an = ?';           $p[] = $an; }

$where = $w ? 'WHERE ' . implode(' AND ', $w) : '';

$rows = q("SELECT cat.nume AS categorie, u.sex, u.nr_pacienti, u.an
           FROM sex_urgente u
           JOIN categorii_droguri cat ON cat.id = u.id_categorie
           $where
           ORDER BY u.an, cat.nume, u.sex", $p);

respond(['data' => $rows, 'total' => count($rows)]);
