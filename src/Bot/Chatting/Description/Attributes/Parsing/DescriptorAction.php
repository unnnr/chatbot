<?php

namespace ChatBot\Bot\Chatting\Description\Attributes\Parsing;

use ChatBot\Bot\Chatting\Description\Attributes\AttributeDescriptor;
use ChatBot\Bot\Chatting\Description\Attributes\Types\DialogFallback;
use ChatBot\Bot\Chatting\Description\Attributes\Types\GroupFallback;
use ChatBot\Bot\Chatting\Description\Attributes\Types\WaitForReply;
use ChatBot\Bot\Chatting\Description\Attributes\Types\Step;

class DescriptorAction
{
    public function __construct(
        private \ReflectionMethod $method,
        private AttributeDescriptor $instance
    ) {}

    public function isGroupFallback(): bool
    {
        return (bool) $this->method->getAttributes(GroupFallback::class);
    }

    public function isDialogFallback(): bool
    {
        return (bool) $this->method->getAttributes(DialogFallback::class);
    }

    public function requireInput(): bool
    {
        return (bool) $this->method->getAttributes(WaitForReply::class);
    }

    public function isStep(): bool
    {
        return (bool) $this->method->getAttributes(Step::class);
    }

    public function toCallable()
    {
        return [$this->instance, $this->method->getName()];
    }
}