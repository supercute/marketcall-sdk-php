<?php

declare(strict_types=1);

namespace MarketCall\Model;

class Merchant extends AbstractModel
{
    public function __construct(
        public int     $id,
        public string  $name,
        public string  $email,
        public ?string $phone,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
