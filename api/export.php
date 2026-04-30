<?php
require_once __DIR__ . '/_base.php';

$section = $_GET['section'] ?? '';
$format  = strParam('format', ['csv', 'json']) ?? 'csv';

// Refolosim aceeași logică de query ca endpoint-urile individuale
$allowed = ['confiscari', 'condamnari', 'urgente', 'tratament', 'actiuni', 'boli'];
if (!in_array($section, $allowed, true)) {
    respondError('Secțiune invalidă.');
}

// Include endpoint-ul corespunzător și capturăm datele
ob_start();
require __DIR__ . '/' . $section . '.php';
$json = ob_get_clean();
$result = json_decode($json, true);
$rows = $result['data'] ?? [];

if ($format === 'json') {
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $section . '.json"');
    echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $section . '.csv"');

$out = fopen('php://output', 'w');
fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM pentru Excel

if (!empty($rows)) {
    fputcsv($out, array_keys($rows[0]));
    foreach ($rows as $row) {
        fputcsv($out, $row);
    }
}
fclose($out);
exit;
