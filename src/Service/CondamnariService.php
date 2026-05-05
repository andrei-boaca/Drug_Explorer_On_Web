<?php

require_once __DIR__ . '/../DTO/CondamnariDTO.php';
require_once __DIR__ . '/../Repository/CondamnariRepository.php';

class CondamnariService
{
    public function __construct(private CondamnariRepository $repository) {}

    /** @return CondamnariDTO[] */
    public function getCondamnari(?int $an, ?string $sex): array
    {
        $rows = $this->repository->findAll($an, $sex);
        return array_map(fn(array $row) => CondamnariDTO::fromRow($row), $rows);
    }
}
