<?php

declare(strict_types=1);

namespace MarketCall\Model;

class Paginator extends AbstractModel
{
    public function __construct(
        public int     $totalCount,
        public int     $totalPages,
        public int     $currentPage,
        public int     $limit,
        public ?string $next,
        public ?string $prev,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            totalCount: $data['total_count'],
            totalPages: $data['total_pages'],
            currentPage: $data['current_page'],
            limit: $data['limit'],
            next: $data['next'] ?? null,
            prev: $data['prev'] ?? null,
        );
    }

    public function hasNext(): bool
    {
        return $this->next !== null;
    }

    public function hasPrev(): bool
    {
        return $this->prev !== null;
    }

    public function toArray(): array
    {
        return [
            'total_count' => $this->totalCount,
            'total_pages' => $this->totalPages,
            'current_page' => $this->currentPage,
            'limit' => $this->limit,
            'next' => $this->next,
            'prev' => $this->prev,
        ];
    }
}
