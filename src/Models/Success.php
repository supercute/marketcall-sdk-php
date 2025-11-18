<?php

namespace Marketcall\Models;

class Success extends AbstractModel
{

    public function __construct(
        public bool $success = true
    )
    {
    }

    public static function fromArray(array $data): AbstractModel
    {
        return new self(
            success: $data['success'],
        );
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
        ];
    }

}
