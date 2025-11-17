<?php

declare(strict_types=1);

namespace Marketcall\Request\Calls;

use Marketcall\Request\AbstractRequest;

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
