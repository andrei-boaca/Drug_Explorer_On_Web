<?php

class ActiuniRepository
{
    public function __construct(private PDO $pdo) {}

    public function findAll(?int $an): array
    {
        $params = [];
        $where  = [];

        if ($an !== null) { $where[] = 'a.an = ?'; $params[] = $an; }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $stmt = $this->pdo->prepare(
            "SELECT p.nume AS proiect, a.nr_beneficiari, a.an
             FROM actiuni a
             JOIN proiecte p ON p.id = a.id_proiect
             $whereClause
             ORDER BY a.an, a.nr_beneficiari DESC"
        );
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
