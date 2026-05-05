<?php

class FilterOptionDTO
{
    public function __construct(
        public int    $id,
        public string $label
    ) {}

    public static function fromRow(array $row): self
    {
        return new self(
            id:    (int) $row['id'],
            label: $row['label']
        );
    }

    public function toArray(): array
    {
        return [
            'id'    => $this->id,
            'label' => $this->label,
        ];
    }
}
