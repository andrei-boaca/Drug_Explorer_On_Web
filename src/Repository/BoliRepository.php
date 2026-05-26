<?php

class BoliRepository
{
    public function __construct(private PDO $pdo) {}

    public function findAll(?int $boala_id): array
    {
        $params = [];
        $where  = [];

        if ($boala_id !== null) { $where[] = 'ps.id_boala = ?'; $params[] = $boala_id; }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $stmt = $this->pdo->prepare(
            "SELECT b.nume AS boala, ps.sex, ps.nr_testati, ps.nr_pozitivi,
                    ROUND(ps.nr_pozitivi * 100.0 / NULLIF(ps.nr_testati, 0), 1) AS rata_pozitivi
             FROM prevalenta_sex ps
             JOIN boli b ON b.id = ps.id_boala
             $whereClause
             ORDER BY b.nume, ps.sex"
        );
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
