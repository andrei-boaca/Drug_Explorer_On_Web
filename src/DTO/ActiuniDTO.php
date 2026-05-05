<?php

class ActiuniDTO
{
    public function __construct(
        public string $proiect,
        public int    $nr_beneficiari,
        public int    $an
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            proiect:         $row['proiect'],
            nr_beneficiari:  (int) $row['nr_beneficiari'],
            an:              (int) $row['an']
        );
    }

    public function toArray(): array
    {
        return [
            'proiect'        => $this->proiect,
            'nr_beneficiari' => $this->nr_beneficiari,
            'an'             => $this->an,
        ];
    }
}
