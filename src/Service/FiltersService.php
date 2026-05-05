<?php

require_once __DIR__ . '/../DTO/FilterOptionDTO.php';
require_once __DIR__ . '/../DTO/FiltersDTO.php';
require_once __DIR__ . '/../Repository/FiltersRepository.php';

class FiltersService
{
    public function __construct(private FiltersRepository $repository) {}

    public function getFilters(): FiltersDTO
    {
        $droguri   = array_map(fn(array $r) => FilterOptionDTO::fromRow($r), $this->repository->getDroguri());
        $categorii = array_map(fn(array $r) => FilterOptionDTO::fromRow($r), $this->repository->getCategorii());
        $boli      = array_map(fn(array $r) => FilterOptionDTO::fromRow($r), $this->repository->getBoli());

        return new FiltersDTO($droguri, $categorii, $boli);
    }
}
