<?php

require_once __DIR__ . '/../Service/ExportService.php';

class ExportController
{
    public function __construct(private ExportService $service) {}

    public function handle(): void
    {
        $section = $_GET['section'] ?? '';
        $format  = strParam('format', ['csv', 'json']) ?? 'csv';

        $allowed = ['confiscari', 'condamnari', 'urgente', 'tratament', 'actiuni', 'boli'];
        if (!in_array($section, $allowed, true)) {
            respondError('Secțiune invalidă.');
        }

        $params = [
            'an'           => intParam('an'),
            'boala_id'     => intParam('boala_id'),
            'drog_id'      => intParam('drog_id'),
            'categorie_id' => intParam('categorie_id'),
            'sex'          => strParam('sex', ['Masculin', 'Feminin']),
        ];

        $rows = $this->service->getExportData($section, $params);

        if ($format === 'json') {
            header('Content-Type: application/json; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $section . '.json"');
            echo json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            exit;
        }

        // CSV with UTF-8 BOM for Excel compatibility
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $section . '.csv"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

        if (!empty($rows)) {
            fputcsv($out, array_keys($rows[0]));
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
        }
        fclose($out);
        exit;
    }
}
