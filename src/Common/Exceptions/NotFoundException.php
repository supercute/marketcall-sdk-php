<?php

declare(strict_types=1);

namespace Marketcall\Common\Exceptions;

class NotFoundException extends ApiException
{
    public function __construct(
        string $message = 'Not found',
        int    $code = 404,
    )
    {
        parent::__construct($message, $code);
    }
}
