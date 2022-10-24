<?php

namespace ChatBot\Example\Infrastructure;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use ChatBot\Framework\DI\Dependency;
use ChatBot\Bot\Validation\Builders\MessageMatcher;
use ChatBot\Bot\Validation\Builders\PatternsFactory;
use ChatBot\Bot\Chatting\Description\DialogFactory;

class MatcherDependency extends Dependency
{
    public function process(ContainerBuilder $container)
    {
        $container->register(DialogFactory::class, DialogFactory::class);
        $container->register(PatternsFactory::class, PatternsFactory::class);
        $container->register(MessageMatcher::class, MessageMatcher::class)
            ->setShared(false);
    }
}