<?php

declare(strict_types=1);

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class CallComments extends AbstractModel
{
    public function __construct(
        public ?string $merchant,
        public ?string $affiliate,
        public ?string $marketcall,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            merchant: $data['merchant'] ?? null,
            affiliate: $data['affiliate'] ?? null,
            marketcall: $data['marketcall'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'merchant' => $this->merchant,
            'affiliate' => $this->affiliate,
            'marketcall' => $this->marketcall,
        ];
    }
}
