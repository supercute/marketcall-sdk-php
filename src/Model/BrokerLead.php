<?php

declare(strict_types=1);

namespace Marketcall\Model;

use DateTimeImmutable;

class BrokerLead extends AbstractModel
{
    public function __construct(
        public int                $id,
        public string             $phoneNumber,
        public ?string            $name,
        public int                $programId,
        public ?string            $comment,
        public ?DateTimeImmutable $receivedAt,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            phoneNumber: $data['phone_number'],
            name: $data['name'] ?? null,
            programId: $data['program_id'],
            comment: $data['comment'] ?? null,
            receivedAt: isset($data['received_at']) ? new DateTimeImmutable($data['received_at']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'phone_number' => $this->phoneNumber,
            'name' => $this->name,
            'program_id' => $this->programId,
            'comment' => $this->comment,
            'call_at' => $this->callAt?->format('c'),
            'received_at' => $this->receivedAt?->format('c'),
        ];
    }
}
