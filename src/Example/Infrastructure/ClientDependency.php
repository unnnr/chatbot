<?php

namespace ChatBot\Example\Infrastructure;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use ChatBot\Example\Infrastructure\ConsoleClient;
use ChatBot\Framework\DI\Dependency;
use ChatBot\Bot\BotClient;

class ClientDependency extends Dependency
{
    public function process(ContainerBuilder $container): void
    {
        $container->register(BotClient::class, ConsoleClient::class)
            ->setPublic(true);
    }
}