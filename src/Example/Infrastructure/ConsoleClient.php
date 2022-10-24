<?php

namespace ChatBot\Example\Infrastructure;

use ChatBot\Bot\Conversation\Requests\DummyRequest;
use ChatBot\Bot\Conversation\Conversation;
use ChatBot\Bot\BotClient;

class ConsoleClient implements BotClient
{
    private $listeners = [];


    public function on(callable $listener): void
    {
        $this->listeners[] = $listener;
    }

    public function send(mixed $value): void
    {
        print_r("\033[36m$value\033[0m" . PHP_EOL);
    }

    public function push(Conversation $conversation): void
    {
        foreach ($conversation->popQueue() as $message)
            $this->send($message->getText());
    }

    public function listen(): void
    {
        while (true) {
            $message = new DummyRequest(
                text: readline('Your entry: ' ),
                chat: 1,
                user: 1
            );

            foreach ($this->listeners as $listener)
                $listener($message);
        }
    }
}