<?php

declare(strict_types=1);

namespace Marketcall\Common\Exceptions;

class TooManyRequestsException extends ApiException
{
    private ?int $retryAfter = null;

    public function __construct(
        string $message = 'Too many requests',
        int    $code = 429,
        ?int   $retryAfter = null
    )
    {
        parent::__construct($message, $code);
        $this->retryAfter = $retryAfter;
    }

    /**
     * @return int|null
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }
}
