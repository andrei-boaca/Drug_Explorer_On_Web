<?php

class DrugDetailRepository
{
    public function __construct(private PDO $pdo) {}

    /** Aggregate confiscation totals for a drug name */
    public function getConfiscariSummary(string $drugName): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.nume AS drog,
                    SUM(c.grame)      AS total_grame,
                    SUM(c.comprimate) AS total_comprimate,
                    SUM(c.doze)       AS total_doze,
                    SUM(c.mililitri)  AS total_mililitri,
                    SUM(c.nr_capturi) AS total_capturi
             FROM confiscari c
             JOIN tipuri_droguri t ON t.id = c.id_drog
             WHERE t.nume = ?"
        );
        $stmt->execute([$drugName]);
        return $stmt->fetch() ?: [];
    }

    /** Get the category name for a drug (via tipuri_droguri → categorii_droguri) */
    public function getDrugCategoryName(string $drugName): ?string
    {
        $stmt = $this->pdo->prepare(
            "SELECT cat.nume
             FROM tipuri_droguri t
             JOIN categorii_droguri cat ON cat.id = t.id_categorie
             WHERE t.nume = ?
             LIMIT 1"
        );
        $stmt->execute([$drugName]);
        $row = $stmt->fetch();
        return $row ? $row['nume'] : null;
    }

    /** All urgente sub-breakdowns for a category name */
    public function getUrgenteBreakdowns(string $categoryName): array
    {
        return [
            'sex'        => $this->fetchBreakdown('sex_urgente',       'sex',        'nr_pacienti', $categoryName),
            'varsta'     => $this->fetchBreakdown('varsta_urgente',     'interval',   'nr_pacienti', $categoryName),
            'cale'       => $this->fetchBreakdown('cale_administrare',  'cale',       'nr_pacienti', $categoryName),
            'diagnostic' => $this->fetchBreakdown('diagnostic_urgenta', 'diagnostic', 'nr_pacienti', $categoryName),
        ];
    }

    /** All tratament sub-breakdowns for a category name */
    public function getTratamentBreakdowns(string $categoryName): array
    {
        return [
            'regim'    => $this->fetchBreakdown('regim_tratament',   'regim',    'nr_pacienti', $categoryName),
            'sex'      => $this->fetchBreakdown('sex_pacienti',      'sex',      'nr_pacienti', $categoryName),
            'varsta'   => $this->fetchBreakdown('varsta_pacienti',   'interval', 'nr_pacienti', $categoryName),
            'ocupatie' => $this->fetchBreakdown('ocupatie_pacienti', 'ocupatie', 'nr_pacienti', $categoryName),
        ];
    }

    private function fetchBreakdown(string $table, string $labelCol, string $valueCol, string $categoryName): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT t.`{$labelCol}` AS label, SUM(t.`{$valueCol}`) AS valoare
             FROM `{$table}` t
             JOIN categorii_droguri cat ON cat.id = t.id_categorie
             WHERE cat.nume = ?
             GROUP BY t.`{$labelCol}`
             ORDER BY valoare DESC"
        );
        $stmt->execute([$categoryName]);
        return $stmt->fetchAll();
    }
}
