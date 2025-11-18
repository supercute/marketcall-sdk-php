<?php

declare(strict_types=1);

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class Offer extends AbstractModel
{
    public function __construct(
        public int         $id,
        public string      $title,
        public int         $epcw,
        public float       $icr,
        public int         $state,
        public bool        $isSmartlink,
        public Country     $country,
        public array       $regions,
        public array       $categories,
        public int         $keyCallsPercent,
        public string      $limit,
        public string      $about,
        public string      $rules,
        public array       $allowedTrafficSources,
        public array       $acceptableTrafficSources,
        public array       $tariffs,
        public array       $leadTariffs,
        public array       $programs,
        public OfferTools  $tools,
        public array       $reserves,
        public OfferLimits $limits
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            epcw: (int)$data['epcw'],
            icr: (float)$data['icr'],
            state: (int)$data['state'],
            isSmartlink: filter_var($data['is_smartlink'], FILTER_VALIDATE_BOOLEAN),
            country: Country::fromArray($data['country']),
            regions: $data['regions'] ?? [],
            categories: $data['categories'] ?? [],
            keyCallsPercent: (int)$data['key_calls_percent'],
            limit: $data['limit'],
            about: $data['about'],
            rules: $data['rules'],
            allowedTrafficSources: $data['allowed_traffic_sources'] ?? [],
            acceptableTrafficSources: array_map(
                fn(array $item) => AcceptableTrafficSource::fromArray($item),
                $data['acceptable_traffic_sources'] ?? []
            ),
            tariffs: $data['tariffs'] ?? [],
            leadTariffs: array_map(
                fn(array $item) => LeadTariff::fromArray($item),
                $data['lead_tariffs'] ?? []
            ),
            programs: $data['programs'] ?? [],
            tools: OfferTools::fromArray($data['tools'] ?? []),
            reserves: $data['reserves'] ?? [],
            limits: OfferLimits::fromArray($data['limits'] ?? []),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'epcw' => $this->epcw,
            'icr' => $this->icr,
            'state' => $this->state,
            'is_smartlink' => $this->isSmartlink,
            'country' => $this->country->toArray(),
            'regions' => $this->regions,
            'categories' => $this->categories,
            'key_calls_percent' => $this->keyCallsPercent,
            'limit' => $this->limit,
            'about' => $this->about,
            'rules' => $this->rules,
            'allowed_traffic_sources' => $this->allowedTrafficSources,
            'acceptable_traffic_sources' => array_map(
                fn(AcceptableTrafficSource $ats) => $ats->toArray(),
                $this->acceptableTrafficSources
            ),
            'tariffs' => $this->tariffs,
            'lead_tariffs' => array_map(
                fn(LeadTariff $lt) => $lt->toArray(),
                $this->leadTariffs
            ),
            'programs' => $this->programs,
            'tools' => $this->tools->toArray(),
            'hidden' => $this->hidden,
            'reserves' => $this->reserves,
            'limits' => $this->limits->toArray(),
        ];
    }
}
