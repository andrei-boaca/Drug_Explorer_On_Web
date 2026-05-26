<?php

require_once __DIR__ . '/../DTO/ConfiscariDTO.php';
require_once __DIR__ . '/../Repository/ConfiscariRepository.php';

class ConfiscariService
{
    public function __construct(private ConfiscariRepository $repository) {}

    /** @return ConfiscariDTO[] */
    public function getConfiscari(?int $drog_id, ?int $an): array
    {
        $rows = $this->repository->findAll($drog_id, $an);
        return array_map(fn(array $row) => ConfiscariDTO::fromRow($row), $rows);
    }
}
