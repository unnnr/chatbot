<?php

namespace ChatBot\Framework;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use ChatBot\Framework\DI\Containers\SymfonyContainer;
use ChatBot\Framework\DI\Loading\DependencyLoader;
use ChatBot\Framework\Config\ConfigLoader;
use ChatBot\Framework\Config\EnvLoader;

class Booter
{
    public function __construct(
        private ContainerBuilder $container = new ContainerBuilder()
    ) {}

    public function loadEnvFrom(string $rootDir): void
    {
        (new EnvLoader($rootDir))
            ->load();
    }

    public function loadConfigFrom(string $rootDir): void
    {
        (new ConfigLoader($rootDir))
            ->loadTo($this->container);
    }

    public function loadDependenciesFrom(array $dependencies): void
    {
        (new DependencyLoader($dependencies))
            ->loadTo($this->container);
    }

    public function getContainer(): SymfonyContainer
    {
        if (!!!$this->container->isCompiled())
            $this->container->compile(resolveEnvPlaceholders: true);

        return new SymfonyContainer($this->container);
    }
}