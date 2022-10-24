<?php

namespace ChatBot\Bot\Chatting\Group;

use ChatBot\Bot\Chatting\Resolving\StepResolver;
use ChatBot\Bot\Chatting\Dialog\Fallback;

class StepGroup
{
    public function __construct(
        private array $steps, 
        private ?Fallback $fallback = null
    ) {}

    public function proceedWith(StepResolver $resolver): void
    {
        foreach ($this->steps as $step)
            $resolver->resolve($step, $this->fallback);
    }
}