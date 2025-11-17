<?php

declare(strict_types=1);

namespace Marketcall\Request\Leads;

use DateTimeInterface;
use Marketcall\Request\AbstractRequest;

class LeadsRequest extends AbstractRequest
{
    private ?array $ids = null;
    private ?array $states = null;
    private ?DateTimeInterface $dateFrom = null;
    private ?DateTimeInterface $dateTo = null;
    private ?array $offers = null;
    private ?array $merchantOwnIds = null;
    private ?array $bodyName = null;
    private ?array $bodyEmail = null;
    private ?array $bodyPhone = null;

    public function setIds(?array $ids): self
    {
        $this->ids = $ids;
        return $this;
    }

    public function setStates(?array $states): self
    {
        $this->states = $states;
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

    public function setMerchantOwnIds(?array $merchantOwnIds): self
    {
        $this->merchantOwnIds = $merchantOwnIds;
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

        if ($this->ids !== null) {
            $result['id'] = $this->ids;
        }
        if ($this->states !== null) {
            $result['state'] = $this->states;
        }
        if ($this->dateFrom !== null) {
            $result['date_from'] = $this->dateFrom->format('c');
        }
        if ($this->dateTo !== null) {
            $result['date_to'] = $this->dateTo->format('c');
        }
        if ($this->offers !== null) {
            $result['offer'] = $this->offers;
        }
        if ($this->merchantOwnIds !== null) {
            $result['merchant_own_id'] = $this->merchantOwnIds;
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
