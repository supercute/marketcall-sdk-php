<?php

declare(strict_types=1);

namespace MarketCall\Request\Leads;

use MarketCall\Request\AbstractRequest;

class RefuseLeadRequest extends AbstractRequest
{
    private string $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    public function toArray(): array
    {
        return ['reason' => $this->reason];
    }
}
