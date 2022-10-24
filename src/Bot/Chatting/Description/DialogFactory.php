<?php

namespace ChatBot\Bot\Chatting\Description;

use ChatBot\Bot\Chatting\Description\DialogDescriptor;
use ChatBot\Bot\Chatting\Dialog\Dialog;

class DialogFactory
{
    public function makeFrom(DialogDescriptor $descriptor): Dialog
    {
        return $descriptor->makeDialog();
    }
}