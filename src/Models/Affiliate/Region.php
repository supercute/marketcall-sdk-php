<?php

declare(strict_types=1);

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class Region extends AbstractModel
{
    public function __construct(
        public int    $id,
        public string $name,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
        ], fn($value) => $value !== null);
    }
}
