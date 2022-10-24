<?php

namespace ChatBot\Bot\Routing;

use ChatBot\Bot\Conversation\Requests\Request;
use ChatBot\Bot\Chatting\Channel\ChannelStorage;
use ChatBot\Bot\Chatting\Channel\Channel;
use ChatBot\Bot\Routing\RouteMatcher;

class RouterService
{
    private RouteMatcher $matcher;

    private ChannelStorage $channels;


    public function __construct(
        RouteMatcher $matcher,
        ChannelStorage $channels,
        RouterDescriptor $routes,
    ) {
        $routes->describe($matcher);
        $this->matcher = $matcher;
        $this->channels = $channels;
    }

    function match(Request $request): ?Channel
    {
        $channel = $this->channels->findOrCreateBy(
            $request->getChatId()
        );

        if ($channel->isProcesseingDialog())
            return $channel;
        
        $dialog = $this->matcher->handle($request);
        if (!!!$dialog)
            return null;

        $channel->setDialog($dialog);
        return $channel;
    }
}