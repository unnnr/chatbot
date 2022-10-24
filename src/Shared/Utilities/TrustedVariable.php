<?php

namespace ChatBot\Shared\Utilities;

class TrustedVariable
{
    private mixed $target;


    public function __construct(mixed $defaultValue = null)
    {
        $this->target = $defaultValue;
    }

    public function getValue(): mixed
    {
        if ($this->isAssigned())
            return $this->target;
        
        throw new \LogicException('Value hasn\'t been assigned');
    }

    public function setValue(mixed $value): void
    {
        $this->target = $value;
    }

    public function isAssigned(): bool
    {
        return !!!is_null($this->target);

    }
}