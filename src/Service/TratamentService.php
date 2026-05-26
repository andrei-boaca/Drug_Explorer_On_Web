<?php

require_once __DIR__ . '/../DTO/TratamentDTO.php';
require_once __DIR__ . '/../Repository/TratamentRepository.php';

class TratamentService
{
    public function __construct(private TratamentRepository $repository) {}

    /** @return TratamentDTO[] */
    public function getTratament(?int $cat_id, ?int $an): array
    {
        $rows = $this->repository->findAll($cat_id, $an);
        return array_map(fn(array $row) => TratamentDTO::fromRow($row), $rows);
    }
}
