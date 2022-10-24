<?php

namespace ChatBot\Framework\DI\Resolving\Utilities;

use Psr\Container\ContainerInterface;

class DependencyResolver
{
    public function __construct(
        private ContainerInterface $container
    ) {}

    public function resolve(array $names): array
    {
        $dependencies = [];
        foreach ($names as $name)
            $dependencies[] = $this->container->get($name);

        return $dependencies;
    }
}