<?php

class CondamnariRepository
{
    public function __construct(private PDO $pdo) {}

    public function findAll(?int $an, ?string $sex): array
    {
        $params = [];
        $where  = [];

        if ($an  !== null) { $where[] = 'an = ?';  $params[] = $an; }
        if ($sex !== null) { $where[] = 'sex = ?'; $params[] = $sex; }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        $stmt = $this->pdo->prepare(
            "SELECT numar, sex,
                    CASE WHEN minor = 1 THEN 'Minor' ELSE 'Major' END AS varsta_grup,
                    an
             FROM condamnari
             $whereClause
             ORDER BY an, sex, minor"
        );
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
