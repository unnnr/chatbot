<?php

namespace ChatBot\Bot;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ChatBot\Bot\Chatting\Channel\ChannelStorage;
use ChatBot\Bot\Conversation\Requests\Request;
use ChatBot\Bot\Routing\RouterService;
use ChatBot\Bot\BotClient;
use ChatBot\Framework\App;

class BotApp implements App
{
    public function __construct(
        private BotClient $bot,
        private RouterService $router,
        private ContainerInterface $container,
        private ChannelStorage $channelStorage,
    ) {}

    public function init(): void
    {
        $this->bot->on(function (Request $message) {
            try {
                $channel = $this->router->match($message);
                if (!!!$channel)
                    return;

                $conversation = $channel->handle($this->container, $message);
                $this->channelStorage->save($channel);
                $this->bot->push($conversation);
            }
            catch(\Throwable $error) {
                $this->bot->send($error->getMessage());
            }
        });
        $this->bot->listen();
    }
}