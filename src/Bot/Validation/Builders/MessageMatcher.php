<?php

namespace ChatBot\Bot\Validation\Builders;

use ChatBot\Bot\Validation\Patterns\MessagePattern;
use ChatBot\Bot\Validation\Builders\CaseBuilder;
use ChatBot\Bot\Validation\MatchingCase;
use ChatBot\Bot\Conversation\Message;

class MessageMatcher
{
    private array $cases = []; 


    public function add(MatchingCase $case): void
    {
        $this->cases[] = $case;
    }

    public function on(MessagePattern $pattern): CaseBuilder
    {
        return new CaseBuilder(
            matcher: $this,
            pattern: $pattern
        );
    }

    public function handle(Message $message): mixed
    {
        foreach ($this->cases as $case) {
            if ($case->match($message))
                return $case->proceed();
        }

        return null;
    }
}