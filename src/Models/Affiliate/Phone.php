<?php

namespace Marketcall\Models\Affiliate;

use DateTimeImmutable;
use Marketcall\Models\AbstractModel;

class Phone extends AbstractModel
{
    public function __construct(
        public int                 $id,
        public int                 $programId,
        public string              $phoneNumber,
        public ?\DateTimeImmutable $dateFrom,
        public ?\DateTimeImmutable $dateTo,
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
            programId: $data['program_id'] ?? null,
            phoneNumber: $data['phone_number'],
            dateFrom: isset($data['date_from']) ? new DateTimeImmutable($data['date_from']) : null,
            dateTo: isset($data['date_to']) ? new DateTimeImmutable($data['date_to']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'program_id' => $this->programId,
            'phone_number' => $this->phoneNumber,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
        ];
    }
}
