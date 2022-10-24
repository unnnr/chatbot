<?php

namespace ChatBot\Bot\Chatting\Step;

use ChatBot\Bot\Validation\Patterns\MessagePattern;
use ChatBot\Bot\Chatting\Resolving\Proceedable;
use ChatBot\Bot\Chatting\Step\DialogStep;
use ChatBot\Bot\Conversation\Requests\Request;

class ValidateStep extends Proceedable implements DialogStep
{
    public function __construct(
        private MessagePattern $pattern
    ) {}

    public function proceed(Request $message)
    {
        if (!!!$this->pattern->match($message))
            throw new \ValueError('Message didn\'t passes validation rules');
    }
}