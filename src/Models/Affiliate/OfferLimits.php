<?php

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class OfferLimits extends AbstractModel
{
    public function __construct(
        public array $calls,
        public array $leads,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            calls: $data['calls'] ?? [],
            leads: $data['leads'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'calls' => $this->calls,
            'leads' => $this->leads,
        ];
    }
}
