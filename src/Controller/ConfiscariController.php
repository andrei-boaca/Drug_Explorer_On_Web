<?php

require_once __DIR__ . '/../Service/ConfiscariService.php';

class ConfiscariController
{
    public function __construct(private ConfiscariService $service) {}

    public function handle(): void
    {
        $drog_id = intParam('drog_id');
        $an      = intParam('an');
        $dtos    = $this->service->getConfiscari($drog_id, $an);
        $data    = array_map(fn(ConfiscariDTO $dto) => $dto->toArray(), $dtos);
        respond(['data' => $data, 'total' => count($data)]);
    }
}
