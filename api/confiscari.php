<?php
require_once __DIR__ . '/_base.php';

$p = []; $w = [];

$drog_id = intParam('drog_id');
$an      = intParam('an');

if ($drog_id !== null) { $w[] = 'c.id_drog = ?'; $p[] = $drog_id; }
if ($an      !== null) { $w[] = 'c.an = ?';      $p[] = $an; }

$where = $w ? 'WHERE ' . implode(' AND ', $w) : '';

$rows = q("SELECT t.nume AS drog, c.grame, c.comprimate, c.doze,
                  c.mililitri, c.nr_capturi, c.an
           FROM confiscari c
           JOIN tipuri_droguri t ON t.id = c.id_drog
           $where
           ORDER BY c.an, t.nume", $p);

respond(['data' => $rows, 'total' => count($rows)]);
