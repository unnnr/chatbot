<?php

namespace ChatBot\Example\Infrastructure;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use ChatBot\Example\Infrastructure\InMemmoryChannelStorage;
use ChatBot\Framework\DI\Dependency;
use ChatBot\Bot\Chatting\Channel\ChannelStorage;

class ChannelDependency extends Dependency
{
    public function process(ContainerBuilder $container)
    {
        $container->register(ChannelStorage::class, InMemmoryChannelStorage::class)
            ->setPublic(true);
    }
}