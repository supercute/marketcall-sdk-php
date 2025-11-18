<?php

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class Country extends AbstractModel
{
    public function __construct(
        public int    $id,
        public string $code
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            code: $data['code'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
        ];
    }
}
