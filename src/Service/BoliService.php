<?php

require_once __DIR__ . '/../DTO/BolaDTO.php';
require_once __DIR__ . '/../Repository/BoliRepository.php';

class BoliService
{
    public function __construct(private BoliRepository $repository) {}

    /** @return BolaDTO[] */
    public function getBoli(?int $boala_id): array
    {
        $rows = $this->repository->findAll($boala_id);
        return array_map(fn(array $row) => BolaDTO::fromRow($row), $rows);
    }
}
