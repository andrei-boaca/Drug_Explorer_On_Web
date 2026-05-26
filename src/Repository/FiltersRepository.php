<?php

class FiltersRepository
{
    public function __construct(private PDO $pdo) {}

    public function getDroguri(): array
    {
        return $this->pdo
            ->query('SELECT id, nume AS label FROM tipuri_droguri ORDER BY nume')
            ->fetchAll();
    }

    public function getCategorii(): array
    {
        return $this->pdo
            ->query('SELECT id, nume AS label FROM categorii_droguri ORDER BY nume')
            ->fetchAll();
    }

    public function getBoli(): array
    {
        return $this->pdo
            ->query('SELECT id, nume AS label FROM boli ORDER BY nume')
            ->fetchAll();
    }
}
