<?php

namespace ChatBot\Bot\Validation\Expressions;

use ChatBot\Bot\Validation\Expressions\Expression;

class CallExpression implements Expression
{
    public function __construct(
        private \Closure $closure
    ) {}

    public function proceed(): mixed
    {
        return ($this->closure)();
    }
}