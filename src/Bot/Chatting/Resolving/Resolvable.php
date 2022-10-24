<?php

namespace ChatBot\Bot\Chatting\Resolving;

interface Resolvable
{
    function getResolver(): callable;
}