<?php

namespace ChatBot\Bot\Validation\Patterns;

use ChatBot\Bot\Conversation\Message;

interface MessagePattern
{
    public function match(Message $message): bool;
}