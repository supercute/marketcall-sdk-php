<?php

declare(strict_types=1);

namespace Marketcall\Model;

use DateTimeImmutable;

class Lead extends AbstractModel
{
    public function __construct(
        public int               $id,
        public ?string           $merchantOwnId,
        public int               $offerId,
        public string            $state,
        public DateTimeImmutable $receivedAt,
        public ?float            $cost,
        public ?Price            $price,
        public ?array            $body,
        public ?LeadAction       $leadAction,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            merchantOwnId: $data['merchant_own_id'] ?? null,
            offerId: $data['offer_id'],
            state: $data['state'],
            receivedAt: new DateTimeImmutable($data['received_at']),
            cost: isset($data['cost']) ? (float)$data['cost'] : null,
            price: isset($data['price']) ? Price::fromArray($data['price']) : null,
            body: $data['body'] ?? null,
            leadAction: isset($data['lead_action'])
                ? LeadAction::fromArray($data['lead_action'])
                : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'merchant_own_id' => $this->merchantOwnId,
            'offer_id' => $this->offerId,
            'state' => $this->state,
            'received_at' => $this->receivedAt->format('Y-m-d\TH:i:sP'),
            'cost' => $this->cost,
            'price' => $this->price?->toArray(),
            'body' => $this->body,
            'lead_action' => $this->leadAction?->toArray(),
        ], fn($value) => $value !== null);
    }
}
