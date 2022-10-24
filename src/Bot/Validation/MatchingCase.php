<?php

namespace ChatBot\Bot\Validation;

use ChatBot\Bot\Validation\Expressions\Expression;
use ChatBot\Bot\Validation\Patterns\MessagePattern;
use ChatBot\Bot\Conversation\Message;

class MatchingCase
{
    public function __construct(
        private MessagePattern $pattern,
        private Expression $expression
    ) {}

    public function match(Message $message): bool
    {
        return $this->pattern->match($message);
    }

    public function proceed(): mixed
    {
        return $this->expression->proceed();
    }
}