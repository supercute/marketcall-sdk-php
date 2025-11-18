<?php

namespace Marketcall\Requests\Affiliate;

use Marketcall\Requests\AbstractRequest;

class ChannelsRequest extends AbstractRequest
{
    private ?array $id = null;
    private ?array $state = null;

    private function setStates(array $states): self
    {
        $this->id = $states;
        return $this;
    }

    private function setOfferStates(array $offerStates): self
    {
        $this->state = $offerStates;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'states' => $this->id,
            'offer_states' => $this->state,
        ], fn($value) => $value !== null);
    }
}
