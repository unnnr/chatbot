<?php

namespace ChatBot\Bot\Chatting\Dialog;

use ChatBot\Bot\Chatting\Resolving\Resolvable;

class Fallback implements Resolvable
{
    private mixed $handler;

    
    public function __construct(callable $handler)
    {
        $this->handler = $handler;
    }

    public function getResolver(): callable
    {
        return $this->handler;
    }
}