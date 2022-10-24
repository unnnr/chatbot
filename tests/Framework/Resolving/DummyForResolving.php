<?php

namespace ChatBot\Tests\Framework\Resolving;

class DummyForResolving
{
    public \Iterator $dependecy;

    public bool $methodCalled; 


    public function __construct(\Iterator $dependecy)
    {
        $this->dependecy = $dependecy;
        $this->methodCalled = false;
    }

    public function init(\Iterator $dependecy)
    {
        $this->methodCalled = true;
        return $dependecy;
    }
}