<?php

namespace ChatBot\Bot\Validation\Patterns;

use ChatBot\Bot\Validation\Patterns\RegexPattern;

class CommandPattern extends RegexPattern
{
    private const COMMAND_IDENTIFICATOR = '!';

    
    public function __construct(string $commandName)
    {
        parent::__construct(
            regex: '/^ *' . self::COMMAND_IDENTIFICATOR . $commandName . '/'
        );
    }
}