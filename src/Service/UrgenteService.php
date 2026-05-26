<?php

require_once __DIR__ . '/../DTO/UrgenteDTO.php';
require_once __DIR__ . '/../Repository/UrgenteRepository.php';

class UrgenteService
{
    public function __construct(private UrgenteRepository $repository) {}

    /** @return UrgenteDTO[] */
    public function getUrgente(?int $cat_id, ?int $an): array
    {
        $rows = $this->repository->findAll($cat_id, $an);
        return array_map(fn(array $row) => UrgenteDTO::fromRow($row), $rows);
    }
}
