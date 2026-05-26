<?php

class CondamnariDTO
{
    public function __construct(
        public int    $numar,
        public string $sex,
        public string $varsta_grup,
        public int    $an
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            numar:       (int) $row['numar'],
            sex:         $row['sex'],
            varsta_grup: $row['varsta_grup'],
            an:          (int) $row['an']
        );
    }

    public function toArray(): array
    {
        return [
            'numar'       => $this->numar,
            'sex'         => $this->sex,
            'varsta_grup' => $this->varsta_grup,
            'an'          => $this->an,
        ];
    }
}
