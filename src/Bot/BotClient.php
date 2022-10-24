<?php

namespace ChatBot\Bot;

use ChatBot\Bot\Conversation\Conversation;

interface BotClient
{
    function push(Conversation $convesation): void;
    function on(callable $listener): void;
    function send($response): void;     
    function listen(): void;
}