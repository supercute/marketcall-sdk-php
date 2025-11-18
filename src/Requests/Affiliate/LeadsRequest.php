<?php

declare(strict_types=1);

namespace Marketcall\Requests\Affiliate;

use DateTimeInterface;
use Marketcall\Requests\AbstractRequest;

class LeadsRequest extends AbstractRequest
{
    private ?array $id = null;
    private ?array $state = null;
    private ?array $program = null;
    private ?array $channel = null;
    private ?DateTimeInterface $dateFrom = null;
    private ?DateTimeInterface $dateTo = null;
    private ?array $offers = null;


    public function setId(?array $ids): self
    {
        $this->id = $ids;
        return $this;
    }

    public function setState(?array $state): self
    {
        $this->state = $state;
        return $this;
    }

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

    public function setChannel(?array $channel): self
    {
        $this->channel = $channel;
        return $this;
    }

    public function setProgram(?array $program): self
    {
        $this->program = $program;
        return $this;
    }

    public function toArray(): array
    {
        $result = [];

        if ($this->id !== null) {
            $result['id'] = $this->id;
        }
        if ($this->state !== null) {
            $result['state'] = $this->state;
        }
        if ($this->dateFrom !== null) {
            $result['date_from'] = $this->dateFrom->format('Y-m-d H:i:s');
        }
        if ($this->dateTo !== null) {
            $result['date_to'] = $this->dateTo->format('Y-m-d H:i:s');
        }
        if ($this->offers !== null) {
            $result['offer'] = $this->offers;
        }
        if ($this->channel !== null) {
            $result['channel'] = $this->channel;
        }
        if ($this->program !== null) {
            $result['program'] = $this->program;
        }

        return $result;
    }
}
