<?php

namespace Marketcall\Models\Affiliate;

class Channel
{
    public function __construct(
        public int                $id,
        public string             $title,
        public string             $key,
        public string             $state,
        public \DateTimeImmutable $createdAt,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            key: $data['key'],
            state: $data['state'],
            createdAt: new \DateTimeImmutable($data['created_at']),
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->title,
            'key' => $this->key,
            'state' => $this->state,
            'createdAt' => $this->createdAt,
        ], fn($value) => $value !== null);
    }
}
