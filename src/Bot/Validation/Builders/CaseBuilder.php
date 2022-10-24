<?php

namespace ChatBot\Bot\Validation\Builders;

use ChatBot\Bot\Validation\Expressions\CallExpression;
use ChatBot\Bot\Validation\Builders\MessageMatcher;
use ChatBot\Bot\Validation\Patterns\MessagePattern;
use ChatBot\Bot\Validation\MatchingCase;

class CaseBuilder
{
    public function __construct(
        private MessagePattern $pattern,
        private MessageMatcher $matcher
    ) {}

    public function call(\Closure $closure): void
    {
        $this->matcher->add(new MatchingCase(
            expression: new CallExpression($closure),
            pattern: $this->pattern
        ));
    }
}