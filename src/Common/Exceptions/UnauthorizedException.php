<?php

declare(strict_types=1);

namespace MarketCall\Common\Exceptions;
class UnauthorizedException extends ApiException
{
    public function __construct(
        string $message = 'Unauthorized',
        int    $code = 401,
    )
    {
        parent::__construct($message, $code);
    }
}
