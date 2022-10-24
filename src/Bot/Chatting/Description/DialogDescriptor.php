<?php

namespace ChatBot\Bot\Chatting\Description;

use ChatBot\Bot\Chatting\Dialog\Dialog;

interface DialogDescriptor
{
    function makeDialog(): Dialog;
}