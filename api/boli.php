<?php
require_once __DIR__ . '/_base.php';

$p = []; $w = [];

$boala_id = intParam('boala_id');
if ($boala_id !== null) { $w[] = 'ps.id_boala = ?'; $p[] = $boala_id; }

$where = $w ? 'WHERE ' . implode(' AND ', $w) : '';

$rows = q("SELECT b.nume AS boala, ps.sex, ps.nr_testati, ps.nr_pozitivi,
                  ROUND(ps.nr_pozitivi * 100.0 / NULLIF(ps.nr_testati, 0), 1) AS rata_pozitivi
           FROM prevalenta_sex ps
           JOIN boli b ON b.id = ps.id_boala
           $where
           ORDER BY b.nume, ps.sex", $p);

respond(['data' => $rows, 'total' => count($rows)]);
