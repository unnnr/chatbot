<?php

namespace ChatBot\Example\Infrastructure;

use ChatBot\Bot\Chatting\Channel\Channel;
use ChatBot\Bot\Chatting\Channel\ChannelStorage;

class InMemmoryChannelStorage implements ChannelStorage
{
    private array $channels = [

    ];


    public function findOrCreateBy(int $chatId): Channel
    {
        if (!!!isset($this->channels[$chatId]))
            $this->channels[$chatId] = new Channel($chatId);

        return $this->channels[$chatId];
    }

    public function save(Channel $channel): void
    {
        //
    }
}