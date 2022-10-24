<?php

namespace ChatBot\Framework;

use ChatBot\Framework\DI\Resolving\Resolver;
use ChatBot\Framework\DI\Container;
use ChatBot\Framework\Booter;

abstract class Kernel
{
    private ?Container $container;
    
    private Booter $booter;
    
    private string $rootDir;

    
    public abstract function getAppClass(): ?string;

    public abstract function getAppDependencies(): array;
    

    public function __construct(string $rootDir, ?Booter $booter = null)
    {
        $this->rootDir = $rootDir;
        $this->booter = $booter ?? new Booter();
        $this->container = null;
    }

    public function boot(): void
    {
        $this->booter->loadEnvFrom($this->rootDir);
        $this->booter->loadConfigFrom($this->rootDir);
        $this->booter->loadDependenciesFrom($this->getDependencies());

        $this->container = $this->booter->getContainer();

        if (is_null($this->getAppClass()))
            return;

        if (!!!is_subclass_of($this->getAppClass(), App::class))
            throw new \LogicException('Method getApp should return subclass of App');

         $this->container->getResolver()
            ->invokeMethod($this->getAppClass(), 'init');
    }

    public function getContainer(): Container
    {
        if (is_null($this->container))
            throw new \LogicException('Container is initialized only after calling the boot method');

        return $this->container;
    }

    public function getDependencies(): array
    {
        return [
            ...$this->getAppDependencies(),
            \ChatBot\Framework\DI\Predefined\ParameterBagDependency::class,
            \ChatBot\Framework\DI\Predefined\ContainerDependency::class,
        ];
    }
}