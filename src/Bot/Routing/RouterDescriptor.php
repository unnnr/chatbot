<?php

namespace ChatBot\Bot\Routing;

use ChatBot\Bot\Routing\RouteMatcher;

interface RouterDescriptor
{
    function describe(RouteMatcher $matcher): void;
}