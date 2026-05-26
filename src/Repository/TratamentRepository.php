<?php

class TratamentRepository
{
    public function __construct(private PDO $pdo) {}

    public function findAll(?int $cat_id, ?int $an): array
    {
        $params = [];
        $where  = [];

        if ($cat_id !== null) { $where[] = 'r.id_categorie = ?'; $params[] = $cat_id; }
        if ($an     !== null) { $where[] = 'r.an = ?';           $params[] = $an; }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $stmt = $this->pdo->prepare(
            "SELECT cat.nume AS categorie, r.regim, r.nr_pacienti, r.an
             FROM regim_tratament r
             JOIN categorii_droguri cat ON cat.id = r.id_categorie
             $whereClause
             ORDER BY r.an, cat.nume, r.regim"
        );
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
