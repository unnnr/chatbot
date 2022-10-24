<?php

namespace ChatBot\Bot\Conversation\Requests;

use ChatBot\Bot\Conversation\Requests\Request;

class DummyRequest implements Request
{
    public function __construct(
        private string $text,
        private int $chat,
        private int $user
    ) {}

    public function getText(): string
    {
        return $this->text;
    }

    public function getChatId(): int
    {
        return $this->chat;
    }

    public function getUserId(): int
    {
        return $this->user;
    }
}