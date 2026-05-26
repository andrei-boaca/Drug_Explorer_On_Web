<?php

class FiltersDTO
{
    /**
     * @param FilterOptionDTO[] $droguri
     * @param FilterOptionDTO[] $categorii
     * @param FilterOptionDTO[] $boli
     */
    public function __construct(
        public array $droguri,
        public array $categorii,
        public array $boli
    ) {}

    public function toArray(): array
    {
        return [
            'droguri'   => array_map(fn(FilterOptionDTO $o) => $o->toArray(), $this->droguri),
            'categorii' => array_map(fn(FilterOptionDTO $o) => $o->toArray(), $this->categorii),
            'boli'      => array_map(fn(FilterOptionDTO $o) => $o->toArray(), $this->boli),
        ];
    }
}
