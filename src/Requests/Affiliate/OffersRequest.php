<?php

declare(strict_types=1);

namespace Marketcall\Requests\Affiliate;

use Marketcall\Requests\AbstractRequest;

class OffersRequest extends AbstractRequest
{
    private ?array $categories = null;
    private ?array $regions = null;
    private ?array $countries = null;
    private ?array $types = null;
    private ?array $state = null;
    private ?array $id = null;
    private ?int $isSmartlink = null;
    private ?int $page = null;
    private ?int $perPage = null;

    public function setCategories(?array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function setRegions(?array $regions): self
    {
        $this->regions = $regions;
        return $this;
    }

    public function setCountries(?array $countries): self
    {
        $this->countries = $countries;
        return $this;
    }

    public function setTypes(?array $types): self
    {
        $this->types = $types;
        return $this;
    }

    public function setState(?array $state): self
    {
        $this->state = $state;
        return $this;
    }

    public function setId(?array $id): self
    {
        // Ограничение до 15 офферов
        $this->id = $id !== null ? array_slice($id, 0, 15) : null;
        return $this;
    }

    public function setIsSmartlink(?int $isSmartlink): self
    {
        $this->isSmartlink = $isSmartlink;
        return $this;
    }

    public function setPage(?int $page): self
    {
        $this->page = $page;
        return $this;
    }

    public function setPerPage(?int $perPage): self
    {
        $this->perPage = min($perPage ?? 10, 100);
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'categories' => $this->categories,
            'regions' => $this->regions,
            'countries' => $this->countries,
            'types' => $this->types,
            'state' => $this->state,
            'id' => $this->id,
            'is_smartlink' => $this->isSmartlink,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ], fn($value) => $value !== null);
    }
}
