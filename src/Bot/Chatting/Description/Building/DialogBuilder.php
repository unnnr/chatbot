<?php

namespace ChatBot\Bot\Chatting\Description\Building;

use ChatBot\Bot\Chatting\Group\GroupIterator;
use ChatBot\Bot\Chatting\Dialog\Fallback;
use ChatBot\Bot\Chatting\Dialog\Dialog;

class DialogBuilder
{
    private ?Fallback $fallback = null; 
    
    private bool $withoutReply = false;
    
    private array $groups = [];


    public function defineFallback(callable $fallback): self
    {
        $this->fallback = new Fallback($fallback);
        return $this;
    }

    public function startWithoutReply(): self
    {
        $this->withoutReply = true;
        return $this;
    }

    public function group(): GroupBuilder
    {
        return $this->groups[] = new GroupBuilder(
            dialog: $this
        );
    }

    public function build(): Dialog
    {
        if (!!!$this->groups)
            throw new \LogicException('Groups array can\'t be empty');

        $iterator = new GroupIterator(
            groups: array_map(fn ($group) => $group->build(), $this->groups),
            withoutReply: $this->withoutReply
        );

        return new Dialog(
            groups: $iterator,
            fallback: $this->fallback
        );
    }
}