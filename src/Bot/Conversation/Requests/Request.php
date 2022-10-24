<?php

namespace ChatBot\Bot\Conversation\Requests;

use ChatBot\Bot\Conversation\Message;

interface Request extends Message
{
    function getChatId(): int;
    function getUserId(): int;
}