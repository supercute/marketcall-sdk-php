<?php

declare(strict_types=1);

namespace Marketcall\Models\Affiliate;

use DateTimeImmutable;
use Marketcall\Models\AbstractModel;
use Marketcall\Models\LeadAction;
use Marketcall\Models\Price;

class Lead extends AbstractModel
{
    public function __construct(
        public int               $id,
        public bool              $isTest,
        public ?string           $sessionUUID,
        public int               $channelId,
        public int               $templateId,
        public int               $programId,
        public ?string           $merchantOwnId,
        public ?string           $affiliateOwnId,
        public int               $offerId,
        public string            $offerTitle,
        public Price             $earn,
        public string            $state,
        public DateTimeImmutable $receivedAt,
        public ?LeadAction       $leadAction,
    )
    {
    }

    public
    static function fromArray(array $data): self
    {
        return new self(
            id: (int)$data['id'],
            isTest: $data['is_test'],
            sessionUUID: $data['session_uuid'] ?? null,
            channelId: (int)$data['channel_id'],
            templateId: (int)$data['template_id'],
            programId: (int)$data['program_id'],
            merchantOwnId: $data['merchant_own_id'] ?? null,
            affiliateOwnId: $data['affiliate_own_id'] ?? null,
            offerId: (int)$data['offer_id'],
            offerTitle: $data['offer_title'],
            earn: Price::fromArray($data['earn']),
            state: $data['state'],
            receivedAt: new DateTimeImmutable($data['received_at']),
            leadAction: isset($data['lead_action'])
                ? LeadAction::fromArray($data['lead_action'])
                : null,
        );
    }

    public
    function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'is_test' => $this->isTest,
            'session_uuid' => $this->sessionUUID,
            'channel_id' => $this->channelId,
            'template_id' => $this->templateId,
            'program_id' => $this->programId,
            'merchant_own_id' => $this->merchantOwnId,
            'affiliate_own_id' => $this->affiliateOwnId,
            'offer_id' => $this->offerId,
            'offer_title' => $this->offerTitle,
            'earn' => $this->earn,
            'state' => $this->state,
            'received_at' => $this->receivedAt,
            'lead_action' => $this->leadAction?->toArray(),
        ], fn($value) => $value !== null);
    }
}
