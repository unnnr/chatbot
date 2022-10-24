<?php

namespace ChatBot\Framework\DI\Resolving;

use ChatBot\Framework\DI\Resolving\Seeking\Seekers;
use Psr\Container\ContainerInterface;

class Resolver
{
    private Seekers $seekers;
    

    public function __construct(ContainerInterface $container)
    {
        $this->seekers = new Seekers($container);
    }

    public function create(string $class): mixed
    {
        $dependecies = [];
        if (method_exists($class, '__construct')) {
            $dependecies = $this->seekers
                ->getMethodSeeker()
                ->seekIn($class, '__construct');
        }
     
        return new $class(...$dependecies);
    }

    public function invokeMethod(string|object $target, string $method): mixed
    {
        if (is_string($target))
            $target = $this->create($target);
        
        $dependecies = $this->seekers
            ->getMethodSeeker()
            ->seekIn($target, $method);
        
        return $target->$method(...$dependecies);
    }

    public function invoke(callable $callable): mixed
    {
        if (is_array($callable))
            return $this->invokeMethod($callable[0], $callable[1]);

        $dependecies = $this->seekers
            ->getFunctionSeeker()
            ->seekIn($callable);

        return $callable(...$dependecies);
    }
}