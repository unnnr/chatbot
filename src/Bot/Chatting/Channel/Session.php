<?php

namespace ChatBot\Bot\Chatting\Channel;

class Session
{
    private $objectes = [];


    public function set(string $key, mixed $value): void
    {
        $this->objectes[$key] = $value;
    }

    public function get(string $key): mixed
    {
        if (!!!$this->has($key))
            throw new \ValueError("Unknown key: $key");

        return $this->objectes[$key];
    }

    public function has(string $key): bool
    {
        return key_exists($key, $this->objectes);
    }
}