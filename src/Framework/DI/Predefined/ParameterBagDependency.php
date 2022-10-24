<?php

namespace ChatBot\Framework\DI\Predefined;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use ChatBot\Framework\DI\Dependency;

class ParameterBagDependency extends Dependency
{
    public function process(ContainerBuilder $container)
    {
        $container->set(ParameterBag::class, $container->getParameterBag());
    }
}