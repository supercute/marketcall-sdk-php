<?php

namespace Marketcall\Requests\Affiliate;

use DateTimeInterface;
use Marketcall\Requests\AbstractRequest;

class CallsCountRequest extends AbstractRequest
{
    private ?DateTimeInterface $dateFrom = null;
    private ?DateTimeInterface $dateTo = null;

    public function setDateFrom(?DateTimeInterface $dateFrom): self
    {
        $this->dateFrom = $dateFrom;
        return $this;
    }

    public function setDateTo(?DateTimeInterface $dateTo): self
    {
        $this->dateTo = $dateTo;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'date_from' => $this->dateFrom?->format('Y-m-d H:i:s'),
            'date_to' => $this->dateTo?->format('Y-m-d H:i:s'),
        ], fn($value) => $value !== null);
    }
}
