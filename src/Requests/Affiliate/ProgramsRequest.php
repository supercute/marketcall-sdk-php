<?php

namespace Marketcall\Requests\Affiliate;

use Marketcall\Requests\AbstractRequest;

class ProgramsRequest extends AbstractRequest
{
    private ?array $states = null;
    private ?array $offerStates = null;

    private function setStates(array $states): self
    {
        $this->states = $states;
        return $this;
    }

    private function setOfferStates(array $offerStates): self
    {
        $this->offerStates = $offerStates;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'states' => $this->states,
            'offer_states' => $this->offerStates,
        ], fn($value) => $value !== null);
    }
}
