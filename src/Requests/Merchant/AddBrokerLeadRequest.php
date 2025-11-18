<?php

declare(strict_types=1);

namespace Marketcall\Requests\Merchant;

use Marketcall\Requests\AbstractRequest;

class AddBrokerLeadRequest extends AbstractRequest
{
    private string $phoneNumber;
    private int $programId;
    private ?string $name = null;
    private ?string $comment = null;
    private ?string $callAt = null; // RFC3339

    public function __construct(string $phoneNumber, int $programId)
    {
        $this->phoneNumber = $phoneNumber;
        $this->programId = $programId;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function setCallAt(?string $callAt): self
    {
        $this->callAt = $callAt;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'phone_number' => $this->phoneNumber,
            'program_id' => $this->programId,
            'name' => $this->name,
            'comment' => $this->comment,
            'call_at' => $this->callAt,
        ], fn($value) => $value !== null);
    }
}
