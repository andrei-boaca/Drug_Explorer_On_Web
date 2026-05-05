<?php

class BolaDTO
{
    public function __construct(
        public string  $boala,
        public string  $sex,
        public int     $nr_testati,
        public int     $nr_pozitivi,
        public ?float  $rata_pozitivi
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            boala:         $row['boala'],
            sex:           $row['sex'],
            nr_testati:    (int) $row['nr_testati'],
            nr_pozitivi:   (int) $row['nr_pozitivi'],
            rata_pozitivi: $row['rata_pozitivi'] !== null ? (float) $row['rata_pozitivi'] : null
        );
    }

    public function toArray(): array
    {
        return [
            'boala'         => $this->boala,
            'sex'           => $this->sex,
            'nr_testati'    => $this->nr_testati,
            'nr_pozitivi'   => $this->nr_pozitivi,
            'rata_pozitivi' => $this->rata_pozitivi,
        ];
    }
}
