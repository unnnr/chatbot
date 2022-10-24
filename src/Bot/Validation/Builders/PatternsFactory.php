<?php

namespace ChatBot\Bot\Validation\Builders;

use ChatBot\Bot\Validation\Patterns\CommandPattern;
use ChatBot\Bot\Validation\Patterns\RegexPattern;

class PatternsFactory
{
    public function command(string $name): CommandPattern
    {
        return new CommandPattern($name);
    }

    public function regex(string $pattern): RegexPattern
    {
        return new RegexPattern($pattern);
    }
}