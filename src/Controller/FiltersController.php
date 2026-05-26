<?php

require_once __DIR__ . '/../Service/FiltersService.php';

class FiltersController
{
    public function __construct(private FiltersService $service) {}

    public function handle(): void
    {
        $dto = $this->service->getFilters();
        respond($dto->toArray());
    }
}
