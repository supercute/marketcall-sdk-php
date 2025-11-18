<?php

declare(strict_types=1);

namespace Marketcall\Requests\Merchant;

use DateTimeInterface;
use Marketcall\Requests\AbstractRequest;

class LeadsRequest extends AbstractRequest
{
    private ?array $id = null;
    private ?array $state = null;
    private ?DateTimeInterface $dateFrom = null;
    private ?DateTimeInterface $dateTo = null;
    private ?array $offer = null;
    private ?array $merchantOwnId = null;
    private ?array $bodyName = null;
    private ?array $bodyEmail = null;
    private ?array $bodyPhone = null;


    public function setId(?array $id): self
    {
        $this->id = $id;
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

    public function setOffer(?array $offer): self
    {
        $this->offer = $offer;
        return $this;
    }

    public function setMerchantOwnId(?array $merchantOwnId): self
    {
        $this->merchantOwnId = $merchantOwnId;
        return $this;
    }

    public function setBodyName(?array $bodyName): self
    {
        $this->bodyName = $bodyName;
        return $this;
    }

    public function setBodyEmail(?array $bodyEmail): self
    {
        $this->bodyEmail = $bodyEmail;
        return $this;
    }

    public function setBodyPhone(?array $bodyPhone): self
    {
        $this->bodyPhone = $bodyPhone;
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
            $result['date_from'] = $this->dateFrom->format('c');
        }
        if ($this->dateTo !== null) {
            $result['date_to'] = $this->dateTo->format('c');
        }
        if ($this->offer !== null) {
            $result['offer'] = $this->offer;
        }
        if ($this->merchantOwnId !== null) {
            $result['merchant_own_id'] = $this->merchantOwnId;
        }

        if ($this->bodyName !== null || $this->bodyEmail !== null || $this->bodyPhone !== null) {
            $result['body'] = [];
            if ($this->bodyName !== null) {
                $result['body']['name'] = $this->bodyName;
            }
            if ($this->bodyEmail !== null) {
                $result['body']['email'] = $this->bodyEmail;
            }
            if ($this->bodyPhone !== null) {
                $result['body']['phone'] = $this->bodyPhone;
            }
        }

        return $result;
    }
}
