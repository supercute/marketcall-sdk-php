<?php

declare(strict_types=1);

namespace Marketcall\Models\Affiliate;

use DateTimeImmutable;
use Marketcall\Models\AbstractModel;

class CallCount extends AbstractModel
{
    public function __construct(
        public int                $count,
        public \DateTimeImmutable $dateFrom,
        public \DateTimeImmutable $dateTo,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            count: $data['count'],
            dateFrom: new DateTimeImmutable($data['date_from']),
            dateTo: new DateTimeImmutable($data['date_to']),
        );
    }

    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
        ];
    }
}
