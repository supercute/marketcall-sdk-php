<?php

declare(strict_types=1);

namespace MarketCall\Model;

class Price extends AbstractModel
{
    public function __construct(
        public float  $value,
        public string $currency,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            value: (float)$data['value'],
            currency: $data['currency'],
        );
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'currency' => $this->currency,
        ];
    }
}
