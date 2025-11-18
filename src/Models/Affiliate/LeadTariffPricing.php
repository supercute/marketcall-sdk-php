<?php

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class LeadTariffPricing extends AbstractModel
{
    public function __construct(
        public string  $model,
        public string  $currency,
        public ?string $amount = null,
        public ?int    $pricePercentage = null,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            model: $data['model'],
            currency: $data['currency'],
            amount: $data['amount'] ?? null,
            pricePercentage: $data['price_percentage'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'model' => $this->model,
            'amount' => $this->amount,
            'price_percentage' => $this->pricePercentage,
            'currency' => $this->currency,
        ];
    }
}
