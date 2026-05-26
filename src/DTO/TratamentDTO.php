<?php

class TratamentDTO
{
    public function __construct(
        public string $categorie,
        public string $regim,
        public int    $nr_pacienti,
        public int    $an
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            categorie:   $row['categorie'],
            regim:       $row['regim'],
            nr_pacienti: (int) $row['nr_pacienti'],
            an:          (int) $row['an']
        );
    }

    public function toArray(): array
    {
        return [
            'categorie'   => $this->categorie,
            'regim'       => $this->regim,
            'nr_pacienti' => $this->nr_pacienti,
            'an'          => $this->an,
        ];
    }
}
