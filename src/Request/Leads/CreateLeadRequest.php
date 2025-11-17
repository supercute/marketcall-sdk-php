<?php

declare(strict_types=1);

namespace Marketcall\Request\Leads;

use Marketcall\Request\AbstractRequest;

class CreateLeadRequest extends AbstractRequest
{
    private string $phoneNumber;
    private ?string $name = null;
    private ?int $programId = null;
    private ?string $comment = null;

    public function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setProgramId(?int $programId): self
    {
        $this->programId = $programId;
        return $this;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'phone_number' => $this->phoneNumber,
            'name' => $this->name,
            'program_id' => $this->programId,
            'comment' => $this->comment,
        ], fn($value) => $value !== null);
    }
}
