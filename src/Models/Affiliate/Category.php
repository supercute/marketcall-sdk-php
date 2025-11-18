<?php

declare(strict_types=1);

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class Category extends AbstractModel
{
    public function __construct(
        public int    $id,
        public string $title,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'title' => $this->title,
        ], fn($value) => $value !== null);
    }
}
