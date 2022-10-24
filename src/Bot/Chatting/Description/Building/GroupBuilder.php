<?php

namespace ChatBot\Bot\Chatting\Description\Building;

use ChatBot\Bot\Validation\Patterns\MessagePattern;
use ChatBot\Bot\Validation\Patterns\RegexPattern;
use ChatBot\Bot\Chatting\Dialog\Fallback;
use ChatBot\Bot\Chatting\Group\StepGroup;
use ChatBot\Bot\Chatting\Step as Steps;

class GroupBuilder
{
    private DialogBuilder $dialog;
    
    private ?Fallback $fallback;
    
    private array $steps;


    public function __construct(DialogBuilder $dialog)
    {
        $this->dialog = $dialog;
        $this->fallback = null;
        $this->steps = [];
    }

    public function defineFallback(callable $fallback): self
    {
        $this->fallback = new Fallback($fallback);
        return $this;
    }

    public function handleReply(callable $handler): self
    {
        $this->steps[] = new Steps\HandleStep($handler);
        return $this;
    }

    public function sendMessage(string $message): self
    {
        $this->steps[] = new Steps\MessageStep($message);
        return $this;
    }

    public function validateReply(MessagePattern|string $pattern): self
    {
        if (is_string($pattern))
            $pattern = new RegexPattern($pattern);

        $this->steps[] = new Steps\ValidateStep($pattern);
        return $this;
    }

    public function build(): StepGroup
    {
        if (!!!$this->steps)
            throw new \LogicException('Steps array can\'t be empty');

        return new StepGroup(
            $this->steps,
            $this->fallback
        );
    }

    public function end(): DialogBuilder
    {
        return $this->dialog;
    }
}