<?php

class DrugDetailController
{
    public function __construct(private DrugDetailService $service) {}

    public function handle(): void
    {
        $section = $_GET['source'] ?? '';
        $label   = trim($_GET['label']  ?? '');

        if ($label === '') {
            respondError('Label lipseste.');
        }

        $allowed = ['confiscari', 'urgente', 'tratament'];
        if (!in_array($section, $allowed, true)) {
            respondError('Sectiune invalida.');
        }

        $data = $this->service->getDetail($section, $label);
        respond(['data' => $data]);
    }
}
