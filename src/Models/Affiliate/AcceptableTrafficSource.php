<?php

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class AcceptableTrafficSource extends AbstractModel
{
    public function __construct(
        public int         $id,
        public string      $title,
        public TrafficType $type
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            type: TrafficType::fromArray($data['type'])
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'type' => $this->type->toArray(),
        ];
    }
}
