<?php

class UrgenteRepository
{
    public function __construct(private PDO $pdo) {}

    public function findAll(?int $cat_id, ?int $an): array
    {
        $params = [];
        $where  = [];

        if ($cat_id !== null) { $where[] = 'u.id_categorie = ?'; $params[] = $cat_id; }
        if ($an     !== null) { $where[] = 'u.an = ?';           $params[] = $an; }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $stmt = $this->pdo->prepare(
            "SELECT cat.nume AS categorie, u.sex, u.nr_pacienti, u.an
             FROM sex_urgente u
             JOIN categorii_droguri cat ON cat.id = u.id_categorie
             $whereClause
             ORDER BY u.an, cat.nume, u.sex"
        );
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
