<?php

declare(strict_types=1);

namespace Marketcall\Requests\Affiliate;

use DateTimeInterface;
use Marketcall\Requests\AbstractRequest;

class CallsRequest extends AbstractRequest
{
    private ?DateTimeInterface $dateFrom = null;
    private ?DateTimeInterface $dateTo = null;
    private ?string $rentNumber = null;
    private ?int $page = null;
    private ?int $perPage = null;

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

    public function setRentNumber(?string $rentNumber): self
    {
        $this->rentNumber = $rentNumber;
        return $this;
    }


    public function setPage(?int $page): self
    {
        $this->page = $page;
        return $this;
    }

    public function setPerPage(?int $perPage): self
    {
        $this->perPage = min($perPage ?? 10, 100);
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'date_from' => $this->dateFrom?->format('Y-m-d H:i:s'),
            'date_to' => $this->dateTo?->format('Y-m-d H:i:s'),
            'rent_number' => $this->rentNumber,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ], fn($value) => $value !== null);
    }
}
