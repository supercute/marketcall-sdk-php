<?php

declare(strict_types=1);

namespace Marketcall\Model;

class Account extends AbstractModel
{
    public function __construct(
        public string $number,
        public ?string $title,
        public float  $balance,
        public float  $minBalance,
        public string $currency,
        public string $type
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            number: $data['number'],
            title: $data['title'] ?? null,
            balance: (float)$data['balance'],
            minBalance: (float)$data['min_balance'],
            currency: $data['currency'],
            type: $data['type']
        );
    }

    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'title' => $this->title,
            'balance' => $this->balance,
            'min_balance' => $this->minBalance,
            'currency' => $this->currency,
            'type' => $this->type
        ];
    }
}
