<?php

namespace Marketcall\Models\Affiliate;

class   Source
{
    public function __construct(
        public int    $id,
        public string $title,
        public int    $typeId
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            typeId: (int)$data['type_id']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type_id' => $this->typeId,
        ];
    }
}
