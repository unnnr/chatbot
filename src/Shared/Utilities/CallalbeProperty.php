<?php

namespace ChatBot\Shared\Utilities;

class CallableProperty
{
    /**
     * @var callable
     */
    private mixed $value;


    public function __construct(?callable $value = null)
    {
        $this->value = $value;
    }

    public function set(callable $value)
    {
        $this->value = $value;
    }   

    public function isInitialized(): bool
    {
        return (bool) $this->value;
    }

    public function notInitialized(): bool
    {
        return !!!$this->isInitialized();
    }

    public function __invoke(...$args): mixed
    {
        return ($this->value)(...$args);
    }

    public function get(): callable
    {
        if ($this->value)
            return $this->value;

        throw new \LogicException('Value ins\'t initialized');
    }
}