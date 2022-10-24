<?php

namespace ChatBot\Framework\DI\Loading;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use ChatBot\Framework\DI\Dependency;

class DependencyLoader
{
    public function __construct(
        private array $dependencyList
    ) {}

    public function loadTo(ContainerBuilder $container): void
    {
        foreach ($this->dependencyList as $class) {

            if (!!!class_exists($class))
                throw new \ValueError("Class doesn\'t exists: $class");

            if (!!!is_subclass_of($class, Dependency::class))
                throw new \ValueError("$class must be subclass of " . Dependency::class);

            $dependency = new $class();
            $dependency->process($container);
        }
    }
}