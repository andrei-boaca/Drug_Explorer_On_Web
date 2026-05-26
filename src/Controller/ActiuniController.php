<?php

require_once __DIR__ . '/../Service/ActiuniService.php';

class ActiuniController
{
    public function __construct(private ActiuniService $service) {}

    public function handle(): void
    {
        $an   = intParam('an');
        $dtos = $this->service->getActiuni($an);
        $data = array_map(fn(ActiuniDTO $dto) => $dto->toArray(), $dtos);
        respond(['data' => $data, 'total' => count($data)]);
    }
}
