<?php

declare(strict_types=1);

namespace Marketcall\Common\Exceptions;

class ForbiddenException extends ApiException
{
    public function __construct(
        string $message = 'Forbidden',
        int    $code = 403,
    )
    {
        parent::__construct($message, $code);
    }
}
