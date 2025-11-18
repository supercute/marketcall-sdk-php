<?php

declare(strict_types=1);

namespace Marketcall\Models;

class LeadAction extends AbstractModel
{
    public function __construct(
        public string  $action,
        public ?string $title,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            action: $data['action'],
            title: $data['title'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'action' => $this->action,
            'title' => $this->title,
        ];
    }
}
