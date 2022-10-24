<?php

namespace ChatBot\Bot\Validation\Patterns;

use ChatBot\Bot\Validation\Patterns\MessagePattern;
use ChatBot\Bot\Conversation\Message;

class RegexPattern implements MessagePattern
{
    public function __construct(
        private string $regex
    ) {}

    public function match(Message $message): bool
    {
        return  (bool) preg_match(
            pattern: $this->regex,
            subject: $message->getText()
        );
    }
}