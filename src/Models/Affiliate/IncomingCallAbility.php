<?php

declare(strict_types=1);

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class IncomingCallAbility extends AbstractModel
{
    public function __construct(
        public int  $offerId,
        public bool $ability,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            offerId: $data['offer_id'],
            ability: $data['ability'],
        );
    }

    public function toArray(): array
    {
        return [
            'offer_id' => $this->offerId,
            'ability' => $this->ability,
        ];
    }
}
