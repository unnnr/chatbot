<?php

namespace ChatBot\Example\Infrastructure;

use ChatBot\Framework\DI\Dependency;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use ChatBot\Bot\Validation\Builders\MessageMatcher;
use ChatBot\Bot\Chatting\Description\DialogFactory;
use ChatBot\Bot\Chatting\Channel\ChannelStorage;
use ChatBot\Bot\Routing\RouterDescriptor;
use ChatBot\Bot\Routing\RouteMatcher;
use ChatBot\Bot\Routing\RouterService;
use ChatBot\Example\App\Core\Router;

class RouterDependency extends Dependency
{
    public function process(ContainerBuilder $container)
    {
        $container->register(RouterDescriptor::class, Router::class);
        
        $container->register(RouteMatcher::class, RouteMatcher::class)
            ->setArgument('$matcher', new Reference(MessageMatcher::class))
            ->setArgument('$dialogs', new Reference(DialogFactory::class));

        $container->register(RouterService::class, RouterService::class)
            ->setArgument('$channels', new Reference(ChannelStorage::class))
            ->setArgument('$routes', new Reference(RouterDescriptor::class))
            ->setArgument('$matcher', new Reference(RouteMatcher::class))
            ->setPublic(true);
    }
}