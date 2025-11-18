<?php

declare(strict_types=1);

namespace Marketcall\Requests\Merchant;

use Marketcall\Requests\AbstractRequest;

class CostLeadRequest extends AbstractRequest
{
    private float $cost;

    public function __construct(float $cost)
    {
        $this->cost = $cost;
    }

    public function toArray(): array
    {
        return ['cost' => $this->cost];
    }
}
