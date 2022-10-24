<?php

namespace ChatBot\Bot\Chatting\Resolving;

use ChatBot\Framework\DI\Resolving\Resolver;
use ChatBot\Bot\Chatting\Step\DialogStep;
use ChatBot\Bot\Chatting\Dialog\Fallback;

class StepResolver
{
    public function __construct(
        private Resolver $resolver,
        private FallbackStack $fallbacks
    ) {}

    public function resolve(DialogStep $target, ?Fallback $fallback): void
    {
        $this->fallbacks->forStep($fallback);

        try {
            $this->resolver->invoke($target->getResolver());

        } catch (\Throwable $exception){
            if ($this->fallbacks->hasResolver())
                $this->resolver->invoke($this->fallbacks->getResolver());
            else 
                throw $exception;
        }
    }
}