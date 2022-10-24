<?php

namespace ChatBot\Bot\Chatting\Description\Building;

use ChatBot\Bot\Chatting\Description\Building\DialogBuilder;
use ChatBot\Bot\Chatting\Description\DialogDescriptor;
use ChatBot\Bot\Chatting\Dialog\Dialog;

abstract class BuildingDescriptor implements DialogDescriptor
{
    abstract public function describe(DialogBuilder $dialog): void;


    final public function makeDialog(): Dialog
    {
        $buidler = new DialogBuilder();
        $this->describe($buidler);

        return $buidler->build();
    }
}