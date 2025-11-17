<?php

declare(strict_types=1);

namespace MarketCall\Model;

class LeadAction extends AbstractModel
{
    public function __construct(
        public string  $type,
        public ?string $comment,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            comment: $data['comment'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'comment' => $this->comment,
        ];
    }
}
