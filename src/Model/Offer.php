<?php

declare(strict_types=1);

namespace MarketCall\Model;

class Offer extends AbstractModel
{
    public function __construct(
        public int    $id,
        public string $name,
        public string $description,
        public float  $price,
        public string $currency,
        public bool   $isActive,
        public ?int   $programId,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            description: $data['description'],
            price: (float)$data['price'],
            currency: $data['currency'],
            isActive: $data['is_active'] ?? true,
            programId: $data['program_id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'currency' => $this->currency,
            'is_active' => $this->isActive,
            'program_id' => $this->programId,
        ];
    }
}
