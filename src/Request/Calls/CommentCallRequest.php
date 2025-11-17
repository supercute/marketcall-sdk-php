<?php

declare(strict_types=1);

namespace MarketCall\Request\Calls;

use MarketCall\Request\AbstractRequest;

class CommentCallRequest extends AbstractRequest
{
    private string $comment;

    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    public function toArray(): array
    {
        return ['comment' => $this->comment];
    }
}
