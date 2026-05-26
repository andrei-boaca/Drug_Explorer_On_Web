<?php

class ConfiscariRepository
{
    public function __construct(private PDO $pdo) {}

    public function findAll(?int $drog_id, ?int $an): array
    {
        $params = [];
        $where  = [];

        if ($drog_id !== null) { $where[] = 'c.id_drog = ?'; $params[] = $drog_id; }
        if ($an      !== null) { $where[] = 'c.an = ?';      $params[] = $an; }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $stmt = $this->pdo->prepare(
            "SELECT t.nume AS drog, c.grame, c.comprimate, c.doze,
                    c.mililitri, c.nr_capturi, c.an
             FROM confiscari c
             JOIN tipuri_droguri t ON t.id = c.id_drog
             $whereClause
             ORDER BY c.an, t.nume"
        );
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
