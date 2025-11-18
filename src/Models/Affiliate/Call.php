<?php

declare(strict_types=1);

namespace Marketcall\Models\Affiliate;

use DateTimeImmutable;
use Marketcall\Models\AbstractModel;

class Call extends AbstractModel
{
    public function __construct(
        public int               $id,
        public int               $programId,
        public string            $callerId,
        public int               $duration,
        public string            $state,
        public string            $stateEn,
        public DateTimeImmutable $calldate,
        public float             $price,
        public string            $currency,
        public ?string           $record,
        public CallComments      $comments,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            programId: $data['program_id'],
            callerId: $data['caller_id'],
            duration: $data['duration'],
            state: $data['state'],
            stateEn: $data['state_en'],
            calldate: new DateTimeImmutable($data['calldate']),
            price: (float)$data['price'],
            currency: $data['currency'],
            record: $data['record'] ?? null,
            comments: CallComments::fromArray($data['comments'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'program_id' => $this->programId,
            'caller_id' => $this->callerId,
            'duration' => $this->duration,
            'state' => $this->state,
            'state_en' => $this->stateEn,
            'calldate' => $this->calldate,
            'price' => $this->price,
            'currency' => $this->currency,
            'record' => $this->record,
            'comments' => $this->comments->toArray(),
        ];
    }
}
