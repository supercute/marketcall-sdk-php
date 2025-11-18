<?php

declare(strict_types=1);

namespace Marketcall\Requests\Merchant;

use Marketcall\Requests\AbstractRequest;

class OffersRequest extends AbstractRequest
{
    private ?array $merchants = null;
    private ?array $regions = null;
    private ?array $categories = null;
    private ?array $promotionTypes = null;
    private ?int $state = null;
    private ?int $page = null;
    private ?int $perPage = null;

    public function setMerchants(?array $merchants): self
    {
        $this->merchants = $merchants;
        return $this;
    }

    public function setRegions(?array $regions): self
    {
        $this->regions = $regions;
        return $this;
    }

    public function setCategories(?array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function setPromotionTypes(?array $promotionTypes): self
    {
        $this->promotionTypes = $promotionTypes;
        return $this;
    }

    public function setState(?int $state): self
    {
        $this->state = $state;
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
            'merchants' => $this->merchants,
            'regions' => $this->regions,
            'categories' => $this->categories,
            'promotionTypes' => $this->promotionTypes,
            'state' => $this->state,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ], fn($value) => $value !== null);
    }
}
