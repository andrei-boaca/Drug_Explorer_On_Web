<?php

class ConfiscariDTO
{
    public function __construct(
        public string  $drog,
        public ?float  $grame,
        public ?int    $comprimate,
        public ?int    $doze,
        public ?float  $mililitri,
        public int     $nr_capturi,
        public int     $an
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            drog:       $row['drog'],
            grame:      $row['grame']      !== null ? (float) $row['grame']      : null,
            comprimate: $row['comprimate'] !== null ? (int)   $row['comprimate'] : null,
            doze:       $row['doze']       !== null ? (int)   $row['doze']       : null,
            mililitri:  $row['mililitri']  !== null ? (float) $row['mililitri']  : null,
            nr_capturi: (int) $row['nr_capturi'],
            an:         (int) $row['an']
        );
    }

    public function toArray(): array
    {
        return [
            'drog'       => $this->drog,
            'grame'      => $this->grame,
            'comprimate' => $this->comprimate,
            'doze'       => $this->doze,
            'mililitri'  => $this->mililitri,
            'nr_capturi' => $this->nr_capturi,
            'an'         => $this->an,
        ];
    }
}
