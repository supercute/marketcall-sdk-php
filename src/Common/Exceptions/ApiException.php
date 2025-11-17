<?php

declare(strict_types=1);

namespace Marketcall\Common\Exceptions;

use Exception;
use Throwable;

class ApiException extends Exception
{
    protected array $errors = [];

    public function __construct(
        string     $message = '',
        int        $code = 0,
        ?Throwable $previous = null,
        array      $errors = []
    )
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * Получить детали ошибок валидации
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
