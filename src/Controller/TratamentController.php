<?php

require_once __DIR__ . '/../Service/TratamentService.php';

class TratamentController
{
    public function __construct(private TratamentService $service) {}

    public function handle(): void
    {
        $cat_id = intParam('categorie_id');
        $an     = intParam('an');
        $dtos   = $this->service->getTratament($cat_id, $an);
        $data   = array_map(fn(TratamentDTO $dto) => $dto->toArray(), $dtos);
        respond(['data' => $data, 'total' => count($data)]);
    }
}
