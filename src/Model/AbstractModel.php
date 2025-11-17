<?php

namespace MarketCall\Model;

abstract class AbstractModel
{
    abstract public static function fromArray(array $data): self;

    public function toArray(): array
    {
        return [];
    }
}
