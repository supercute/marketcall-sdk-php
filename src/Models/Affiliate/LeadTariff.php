<?php

namespace Marketcall\Models\Affiliate;

class LeadTariff
{
    public function __construct(
        public string            $title,
        public string            $slug,
        public int               $templateId,
        public string            $saleType,
        public LeadTariffPricing $pricing,
        public int               $holdPeriod,
        public string            $leadCountType,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            slug: $data['slug'],
            templateId: $data['template_id'],
            saleType: $data['sale_type'],
            pricing: LeadTariffPricing::fromArray($data['pricing']),
            holdPeriod: $data['hold_period'],
            leadCountType: $data['lead_count_type'],
        );
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'template_id' => $this->templateId,
            'sale_type' => $this->saleType,
            'pricing' => $this->pricing->toArray(),
            'hold_period' => $this->holdPeriod,
            'lead_count_type' => $this->leadCountType,
        ];
    }
}
