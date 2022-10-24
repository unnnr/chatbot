<?php

namespace ChatBot\Bot\Chatting\Description\Attributes;

use ChatBot\Bot\Chatting\Description\Attributes\Parsing\DescriptorParser;
use ChatBot\Bot\Chatting\Description\DialogDescriptor;
use ChatBot\Bot\Chatting\Dialog\Dialog;


abstract class AttributeDescriptor implements DialogDescriptor
{
    final public function makeDialog(): Dialog
    {
        $parser = new DescriptorParser($this);
        return $parser->createDialog();
    }
}