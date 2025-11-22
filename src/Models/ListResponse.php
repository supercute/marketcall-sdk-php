<?php

declare(strict_types=1);

namespace Marketcall\Models;

class ListResponse
{
    public function __construct(
        public array      $data,
        public ?Paginator $paginator = null,
    )
    {
    }

    public function getData(): array
    {
        return $this->getData();
    }

    public function getPaginator(): ?Paginator
    {
        return $this->paginator;
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'paginator' => $this->paginator,
        ];
    }
}
