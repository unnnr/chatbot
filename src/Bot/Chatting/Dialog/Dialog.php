<?php

namespace ChatBot\Bot\Chatting\Dialog;

use ChatBot\Bot\Chatting\Resolving\StepResolver;
use ChatBot\Bot\Chatting\Group\GroupIterator;
use ChatBot\Bot\Chatting\Dialog\Fallback;

class Dialog
{
    public function __construct(
        private GroupIterator $groups,
        private ?Fallback $fallback = null
    ) {}

    public function getFallback(): ?Fallback
    {
        return $this->fallback;
    }

    public function ended(): bool
    {
        return !!!$this->groups->valid();
    }

    public function reset(): void
    {
        $this->groups->rewind();
    }

    public function skeepGroup()
    {
        if ($this->ended())
            throw new \LogicException('Dialog is already ended');

        $this->groups->next();
    }

    public function rollbackGroup()
    {
        if ($this->ended())
            throw new \LogicException('Dialog is already ended');

        $this->groups->rollback();
    }

    public function proceedWith(StepResolver $resolver): void
    {
        if ($this->ended())
            throw new \LogicException('Dialog is already ended');

        $this->groups->current()?->proceedWith($resolver);
        $this->groups->next();
    }
}