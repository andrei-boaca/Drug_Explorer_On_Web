<?php

require_once __DIR__ . '/../Service/BoliService.php';

class BoliController
{
    public function __construct(private BoliService $service) {}

    public function handle(): void
    {
        $boala_id = intParam('boala_id');
        $dtos     = $this->service->getBoli($boala_id);
        $data     = array_map(fn(BolaDTO $dto) => $dto->toArray(), $dtos);
        respond(['data' => $data, 'total' => count($data)]);
    }
}
