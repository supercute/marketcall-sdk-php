<?php

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class Program extends AbstractModel
{
    public function __construct(
        public int    $id,
        public string $offer,
        public int    $offerId,
        public string $offerStatus,
        public int    $epcw,
        public array  $regions,
        public array  $categories,
        public string $phone,
        public int    $status,
        public array  $sources
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            offer: $data['offer'],
            offerId: (int)$data['offer_id'],
            offerStatus: $data['offer_status'],
            epcw: (int)$data['epcw'],
            regions: $data['regions'] ?? [],
            categories: $data['categories'] ?? [],
            phone: $data['phone'],
            status: (int)$data['status'],
            sources: array_map(
                fn(array $item) => Source::fromArray($item),
                $data['sources'] ?? []
            )
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'offer' => $this->offer,
            'offer_id' => $this->offerId,
            'offer_status' => $this->offerStatus,
            'epcw' => $this->epcw,
            'regions' => $this->regions,
            'categories' => $this->categories,
            'phone' => $this->phone,
            'status' => $this->status,
            'sources' => array_map(
                fn(Source $source) => $source->toArray(),
                $this->sources
            ),
        ];
    }
}
