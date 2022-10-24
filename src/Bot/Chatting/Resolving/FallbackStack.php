<?php

namespace ChatBot\Bot\Chatting\Resolving;

use ChatBot\Bot\Chatting\Dialog\Fallback;

class FallbackStack
{
    private ?Fallback $dialog = null;
    
    private ?Fallback $step = null;


    public function forDialog(?Fallback $value): void
    {
        $this->dialog = $value;
    }

    public function forStep(?Fallback $value): void
    {
        $this->step = $value;
    }

    public function hasResolver(): bool
    {
        return (bool) $this->dialog || $this->step;
    }

    public function getResolver(): callable
    {
        return $this->getActive()->getResolver();
    }

    public function getActive(): Fallback
    {
        if (!!!$this->hasResolver())
            throw new \LogicException('Have no resolver to return');

        return $this->step ?? $this->dialog;
    }
}