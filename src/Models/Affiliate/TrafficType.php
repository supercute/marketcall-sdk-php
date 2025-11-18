<?php

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class TrafficType extends AbstractModel
{
    public function __construct(
        public string $title
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}
