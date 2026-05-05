<?php

require_once __DIR__ . '/../Service/CondamnariService.php';

class CondamnariController
{
    public function __construct(private CondamnariService $service) {}

    public function handle(): void
    {
        $an   = intParam('an');
        $sex  = strParam('sex', ['Masculin', 'Feminin']);
        $dtos = $this->service->getCondamnari($an, $sex);
        $data = array_map(fn(CondamnariDTO $dto) => $dto->toArray(), $dtos);
        respond(['data' => $data, 'total' => count($data)]);
    }
}
