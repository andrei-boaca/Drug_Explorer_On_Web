<?php

require_once __DIR__ . '/../DTO/ActiuniDTO.php';
require_once __DIR__ . '/../Repository/ActiuniRepository.php';

class ActiuniService
{
    public function __construct(private ActiuniRepository $repository) {}

    /** @return ActiuniDTO[] */
    public function getActiuni(?int $an): array
    {
        $rows = $this->repository->findAll($an);
        return array_map(fn(array $row) => ActiuniDTO::fromRow($row), $rows);
    }
}
