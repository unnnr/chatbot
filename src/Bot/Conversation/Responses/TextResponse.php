<?php

namespace ChatBot\Bot\Conversation\Responses;

use ChatBot\Bot\Conversation\Responses\Response;

class TextResponse implements Response
{
    public function __construct(
        private string $message
    ) {}

    public function getText(): string
    {
        return $this->message;
    }
}