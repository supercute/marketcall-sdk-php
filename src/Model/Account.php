<?php

declare(strict_types=1);

namespace MarketCall\Model;

class Account extends AbstractModel
{
    public function __construct(
        public string $number,
        public string $title,
        public string $balance,
        public string $minBalance,
        public string $currency,
        public string $type
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            number: $data['number'],
            title: $data['title'],
            balance: $data['balance'],
            minBalance: $data['min_balance'],
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
