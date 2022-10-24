<?php

namespace ChatBot\Bot\Routing;

use ChatBot\Bot\Conversation\Requests\Request;
use ChatBot\Bot\Validation\Builders\MessageMatcher;
use ChatBot\Bot\Validation\Patterns\CommandPattern;
use ChatBot\Bot\Chatting\Description\DialogDescriptor;
use ChatBot\Bot\Chatting\Description\DialogFactory;
use ChatBot\Bot\Chatting\Dialog\Dialog;

class RouteMatcher
{
    public function __construct(
        private MessageMatcher $matcher,
        private DialogFactory $dialogs
    ) {}
    
    public function handle(Request $request): ?Dialog
    {
        return $this->matcher->handle($request);
    }

    public function on(string $command, DialogDescriptor $descriptor): void
    {
        $this->matcher->on(new CommandPattern($command))
            ->call(fn ()=> $this->dialogs->makeFrom($descriptor));
    }
}