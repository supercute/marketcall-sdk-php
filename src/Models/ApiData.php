<?php

declare(strict_types=1);

namespace Marketcall\Models;

class ApiData extends AbstractModel
{
    public function __construct(public array $data)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
