<?php

namespace ChatBot\Bot\Chatting\Step;

use ChatBot\Bot\Conversation\Responses\TextResponse;
use ChatBot\Bot\Chatting\Resolving\Proceedable;
use ChatBot\Bot\Chatting\Step\DialogStep;
use ChatBot\Bot\Conversation\Conversation;

class MessageStep extends Proceedable implements DialogStep
{
    public function __construct(
        private string $text
    ) {}

    public function proceed(Conversation $conversation)
    {
        $conversation->addReponse(
            response: new TextResponse($this->text)
        );
    }
}   