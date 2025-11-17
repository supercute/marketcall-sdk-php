<?php

declare(strict_types=1);

namespace Marketcall\Common\Exceptions;

class BadRequestException extends ApiException
{
    public function __construct(
        string $message = 'Bad Request',
        int    $code = 400,
    )
    {
        parent::__construct($message, $code);
    }
}
