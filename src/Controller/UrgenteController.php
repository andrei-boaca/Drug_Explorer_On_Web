<?php

require_once __DIR__ . '/../Service/UrgenteService.php';

class UrgenteController
{
    public function __construct(private UrgenteService $service) {}

    public function handle(): void
    {
        $cat_id = intParam('categorie_id');
        $an     = intParam('an');
        $dtos   = $this->service->getUrgente($cat_id, $an);
        $data   = array_map(fn(UrgenteDTO $dto) => $dto->toArray(), $dtos);
        respond(['data' => $data, 'total' => count($data)]);
    }
}
