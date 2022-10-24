<?php

namespace ChatBot\Bot\Chatting\Group;

class GroupIterator implements \Iterator
{

    private array $groups;

    public function __construct(array $groups, bool $withoutReply = true)
    {
        if (!!!$withoutReply)
            array_unshift($groups, null);

        $this->groups = $groups;
        $this->rewind();
    }

    public function current(): ?StepGroup
    {
        if (!!!$this->valid())
            throw new \LogicException('Current points beyond the end of the groups');

        return current($this->groups);
    }

    public function rollback(): void
    {
        if (prev($this->groups) === false)
            reset($this->groups);
    }

    public function next(): void
    {
        next($this->groups);
    }

    public function rewind(): void
    {
        reset($this->groups);
    }

    public function valid(): bool
    {
        return current($this->groups) !== false;
    }

    public function key(): int|string
    {
        return key($this->groups);
    }
}