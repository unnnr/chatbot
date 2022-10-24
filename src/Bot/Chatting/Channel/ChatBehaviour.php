<?php

namespace ChatBot\Bot\Chatting\Channel;

use ChatBot\Bot\Chatting\Channel\Channel;

class ChatBehaviour
{
    public function __construct(
        private Channel $channel
    ) {}
    
    public function endDialog(): void
    {
        $this->channel->forceEnd();
    }

    public function resetDialog(): void
    {
        $this->channel->getDialog()
            ->reset();
    }

    public function skeepGroup(): void
    {
        $this->channel->getDialog()
            ->skeepGroup();
    }

    public function resetGroup()
    {
        $this->channel->getDialog()
            ->rollbackGroup();
    }
}