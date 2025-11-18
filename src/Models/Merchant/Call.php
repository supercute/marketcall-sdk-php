<?php

declare(strict_types=1);

namespace Marketcall\Models\Merchant;

use DateTimeImmutable;
use Marketcall\Models\AbstractModel;

class Call extends AbstractModel
{
    public function __construct(
        public int               $id,
        public string            $callerId,
        public int               $duration,
        public int               $state,
        public DateTimeImmutable $calldate,
        public float             $price,
        public string            $currency,
        public int               $offer,
        public Merchant          $merchant,
        public ?string           $refuseReason,
        public ?string           $merchantComment,
        public ?string           $affiliateComment,
        public ?string           $affiliateTicket,
        public ?string           $marketcallComment,
        public ?string           $record,
        public ?string           $affiliateId,
    )
    {
    }

    /**
     * Создать из массива
     *
     * @param array $data
     * @return self
     * @throws \Exception
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            callerId: $data['caller_id'],
            duration: $data['duration'],
            state: $data['state'],
            calldate: new DateTimeImmutable($data['calldate']),
            price: (float)$data['price'],
            currency: $data['currency'],
            offer: $data['offer'],
            merchant: Merchant::fromArray($data['merchant']),
            refuseReason: $data['refuse_reason'] ?? null,
            merchantComment: $data['merchant_comment'] ?? null,
            affiliateComment: $data['affiliate_comment'] ?? null,
            affiliateTicket: $data['affiliate_ticket'] ?? null,
            marketcallComment: $data['marketcall_comment'] ?? null,
            record: $data['record'] ?? null,
            affiliateId: $data['affiliate_id'] ?? null,
        );
    }

    /**
     * Преобразовать в массив
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'caller_id' => $this->callerId,
            'duration' => $this->duration,
            'state' => $this->state,
            'calldate' => $this->calldate->format('Y-m-d\TH:i:sP'),
            'price' => $this->price,
            'currency' => $this->currency,
            'offer' => $this->offer,
            'merchant' => $this->merchant->toArray(),
            'refuse_reason' => $this->refuseReason,
            'merchant_comment' => $this->merchantComment,
            'affiliate_comment' => $this->affiliateComment,
            'affiliate_ticket' => $this->affiliateTicket,
            'marketcall_comment' => $this->marketcallComment,
            'record' => $this->record,
            'affiliate_id' => $this->affiliateId,
        ];
    }
}
