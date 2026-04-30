<?php
require_once __DIR__ . '/_base.php';

$p = []; $w = [];

$an  = intParam('an');
$sex = strParam('sex', ['Masculin', 'Feminin']);

if ($an  !== null) { $w[] = 'an = ?';  $p[] = $an; }
if ($sex !== null) { $w[] = 'sex = ?'; $p[] = $sex; }

$where = $w ? 'WHERE ' . implode(' AND ', $w) : '';

$rows = q("SELECT numar, sex,
                  CASE WHEN minor = 1 THEN 'Minor' ELSE 'Major' END AS varsta_grup,
                  an
           FROM condamnari
           $where
           ORDER BY an, sex, minor", $p);

respond(['data' => $rows, 'total' => count($rows)]);
