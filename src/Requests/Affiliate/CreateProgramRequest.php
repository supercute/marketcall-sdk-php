<?php

declare(strict_types=1);

namespace Marketcall\Requests\Affiliate;

use Marketcall\Requests\AbstractRequest;

class CreateProgramRequest extends AbstractRequest
{
    public function __construct(
        public int    $offerId,
        public int    $rentId,
        public string $title,
        public array  $trafficSources,
        public string $trafficComment,
        public string $trafficBackUrl,
    )
    {
    }

    public function toArray(): array
    {
        return array_filter([
            'offer_id' => $this->offerId,
            'rent_id' => $this->rentId,
            'title' => $this->title,
            'traffic_sources' => $this->trafficSources,
            'traffic_comment' => $this->trafficComment,
            'trafficback_url' => $this->trafficBackUrl,
        ], fn($value) => $value !== null);
    }
}
