<?php

declare(strict_types=1);

namespace Marketcall\Model;

class Price extends AbstractModel
{
    public function __construct(
        public float  $amount,
        public string $currency,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            amount: (float)$data['amount'],
            currency: $data['currency'],
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
