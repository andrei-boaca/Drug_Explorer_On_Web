<?php

class UrgenteDTO
{
    public function __construct(
        public string $categorie,
        public string $sex,
        public int    $nr_pacienti,
        public int    $an
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            categorie:   $row['categorie'],
            sex:         $row['sex'],
            nr_pacienti: (int) $row['nr_pacienti'],
            an:          (int) $row['an']
        );
    }

    public function toArray(): array
    {
        return [
            'categorie'   => $this->categorie,
            'sex'         => $this->sex,
            'nr_pacienti' => $this->nr_pacienti,
            'an'          => $this->an,
        ];
    }
}
