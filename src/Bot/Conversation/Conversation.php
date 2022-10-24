<?php

namespace ChatBot\Bot\Conversation;

use ChatBot\Bot\Conversation\Responses\TextResponse;
use ChatBot\Bot\Conversation\Responses\Response;

class Conversation
{
    private array $queue = [];


    public function addReponse(Response|string $response)
    {
        if (is_string($response))
            $response = new TextResponse($response);
            
        $this->queue[] = $response;
    }

    public function popQueue(): \Generator
    {
        while(count($this->queue))
            yield array_shift($this->queue);
    }
}