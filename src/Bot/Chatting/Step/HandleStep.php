<?php

namespace ChatBot\Bot\Chatting\Step;

use ChatBot\Bot\Chatting\Step\DialogStep;

class HandleStep implements DialogStep
{
    public function __construct(
        private $callable
    ) {}

    public function getResolver(): callable
    {
        return $this->callable;
    }
}