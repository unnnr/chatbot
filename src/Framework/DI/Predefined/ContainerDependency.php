<?php

namespace ChatBot\Framework\DI\Predefined;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use ChatBot\Framework\DI\Dependency;

class ContainerDependency extends Dependency
{
    public function process(ContainerBuilder $container)
    {
        $container->set(ContainerInterface::class, $container);
    }
}