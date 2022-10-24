<?php

namespace ChatBot\Example\App\Core;

use ChatBot\Framework\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    public function getAppClass(): string
    {
        return \ChatBot\Bot\BotApp::class;
    }   

    public function getAppDependencies(): array
    {
        return [
            \ChatBot\Shared\Dependencies\DoctrineDependency::class,
            \ChatBot\Example\Infrastructure\RouterDependency::class,
            \ChatBot\Example\Infrastructure\ClientDependency::class,
            \ChatBot\Example\Infrastructure\ChannelDependency::class,
            \ChatBot\Example\Infrastructure\MatcherDependency::class,
        ];
    }
}