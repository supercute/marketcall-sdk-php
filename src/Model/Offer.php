<?php

declare(strict_types=1);

namespace Marketcall\Model;

class Offer extends AbstractModel
{
    public function __construct(
        public int $id,
        public string $title,
        public string $phone,
        public bool $isGuest,
        public Merchant $merchant,
        public int $epcw,
        public int $activeProgramsCount,
        public int $keyCallsPercentage,
        public int $state
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            phone: $data['phone'],
            isGuest: filter_var($data['is_guest'], FILTER_VALIDATE_BOOLEAN),
            merchant: Merchant::fromArray($data['merchant']),
            epcw: (int)$data['epcw'],
            activeProgramsCount: (int)$data['active_programs_count'],
            keyCallsPercentage: (int)$data['key_calls_percentage'],
            state: (int)$data['state']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'phone' => $this->phone,
            'is_guest' => $this->isGuest,
            'merchant' => [
                'id' => $this->merchant->id,
                'name' => $this->merchant->name,
            ],
            'epcw' => $this->epcw,
            'active_programs_count' => $this->activeProgramsCount,
            'key_calls_percentage' => $this->keyCallsPercentage,
            'state' => $this->state,
        ];
    }
}
