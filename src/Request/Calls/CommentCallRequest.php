<?php

declare(strict_types=1);

namespace Marketcall\Request\Calls;

use Marketcall\Request\AbstractRequest;

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
