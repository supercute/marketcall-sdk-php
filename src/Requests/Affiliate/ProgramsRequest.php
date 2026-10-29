<?php

namespace Marketcall\Requests\Affiliate;

use Marketcall\Requests\AbstractRequest;

class ProgramsRequest extends AbstractRequest
{
    private ?array $states = null;
    private ?array $offerStates = null;
    private ?array $offerTypes = null;

    public function setStates(?array $states): self
    {
        $this->states = $states;
        return $this;
    }

    public function setOfferStates(?array $offerStates): self
    {
        $this->offerStates = $offerStates;
        return $this;
    }

    public function setOfferTypes(?array $offerTypes): self
    {
        $this->offerTypes = $offerTypes;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'states' => $this->states,
            'offer_states' => $this->offerStates,
            'offer_types' => $this->offerTypes,
        ], fn($value) => $value !== null);
    }
}
