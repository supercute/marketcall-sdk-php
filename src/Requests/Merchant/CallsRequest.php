<?php

declare(strict_types=1);

namespace Marketcall\Requests\Merchant;

use DateTimeInterface;
use Marketcall\Requests\AbstractRequest;

class CallsRequest extends AbstractRequest
{
    private ?DateTimeInterface $dateFrom = null;
    private ?DateTimeInterface $dateTo = null;
    private ?array $offers = null;
    private ?int $durationMin = null;
    private ?int $durationMax = null;
    private ?int $state = null;
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

    public function setOffers(?array $offers): self
    {
        $this->offers = $offers;
        return $this;
    }

    public function setDurationMin(?int $durationMin): self
    {
        $this->durationMin = $durationMin;
        return $this;
    }

    public function setDurationMax(?int $durationMax): self
    {
        $this->durationMax = $durationMax;
        return $this;
    }

    public function setState(?int $state): self
    {
        $this->state = $state;
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
            'offers' => $this->offers,
            'duration_min' => $this->durationMin,
            'duration_max' => $this->durationMax,
            'state' => $this->state,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ], fn($value) => $value !== null);
    }
}
