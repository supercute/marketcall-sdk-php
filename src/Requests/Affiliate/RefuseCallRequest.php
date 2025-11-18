<?php

declare(strict_types=1);

namespace Marketcall\Requests\Affiliate;

use Marketcall\Requests\AbstractRequest;

class RefuseCallRequest extends AbstractRequest
{
    private string $reason;

    public function __construct(string $reason)
    {
        $this->reason = $reason;
    }

    /**
     * Преобразовать в массив
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'reason' => $this->reason,
        ];
    }
}
