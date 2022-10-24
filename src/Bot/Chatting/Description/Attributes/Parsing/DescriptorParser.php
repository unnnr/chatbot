<?php

namespace ChatBot\Bot\Chatting\Description\Attributes\Parsing;

use ChatBot\Bot\Chatting\Description\Attributes\Parsing\DescriptorAction;
use ChatBot\Bot\Chatting\Description\Attributes\AttributeDescriptor;
use ChatBot\Bot\Chatting\Description\Building\DialogBuilder;
use ChatBot\Bot\Chatting\Dialog\Dialog;

class DescriptorParser
{
    public function __construct(
        private AttributeDescriptor $descriptor
    ) {}

    final public function createDialog(): Dialog
    {
        $dialog = new DialogBuilder();
        $dialog->startWithoutReply();
        $group = $dialog->group();

        foreach ($this->getActions() as $action) {

            if ($action->isDialogFallback())
                $dialog->defineFallback($action->toCallable());

            else if ($action->isGroupFallback())
                $group->defineFallback($action->toCallable());

            else if ($action->isStep()) {
                if ($action->requireInput())
                    $group = $dialog->group();

                $group->handleReply($action->toCallable());
            }
        };

        return $dialog->build();
    }

    private function getActions(): \Generator
    {
        $class = new \ReflectionClass($this->descriptor);

        foreach ($class->getMethods() as $method)
            yield new DescriptorAction($method, $this->descriptor);
    }
}