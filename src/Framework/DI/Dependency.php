<?php

namespace ChatBot\Framework\DI;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

abstract class Dependency implements CompilerPassInterface
{
    public final function __construct() {}
}