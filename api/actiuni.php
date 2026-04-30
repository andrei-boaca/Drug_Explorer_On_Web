<?php
require_once __DIR__ . '/_base.php';

$p = []; $w = [];

$an = intParam('an');
if ($an !== null) { $w[] = 'a.an = ?'; $p[] = $an; }

$where = $w ? 'WHERE ' . implode(' AND ', $w) : '';

$rows = q("SELECT p.nume AS proiect, a.nr_beneficiari, a.an
           FROM actiuni a
           JOIN proiecte p ON p.id = a.id_proiect
           $where
           ORDER BY a.an, a.nr_beneficiari DESC", $p);

respond(['data' => $rows, 'total' => count($rows)]);
