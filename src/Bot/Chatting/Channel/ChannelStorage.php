<?php

namespace ChatBot\Bot\Chatting\Channel;

use ChatBot\Bot\Chatting\Channel\Channel;

interface ChannelStorage
{
    function findOrCreateBy(int $channelId): Channel;
    function save(Channel $dialog): void;
}