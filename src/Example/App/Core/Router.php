<?php

namespace ChatBot\Example\App\Core;

use ChatBot\Example\App\Dialogs\ManuallyDescribedDialog;
use ChatBot\Example\App\Dialogs\AttributedDialog;
use ChatBot\Bot\Routing\RouterDescriptor;
use ChatBot\Bot\Routing\RouteMatcher;

class Router implements RouterDescriptor
{
    public function describe(RouteMatcher $matcher): void
    {
        $matcher->on('manually', new ManuallyDescribedDialog());
        $matcher->on('attribute', new AttributedDialog());
    }
}