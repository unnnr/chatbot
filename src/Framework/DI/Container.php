<?php

namespace ChatBot\Framework\DI;

use ChatBot\Framework\DI\Resolving\Resolver;
use Psr\Container\ContainerInterface;

abstract class Container implements ContainerInterface
{
    private Resolver $resolver;


    public function __construct()
    {
        $this->resolver = new Resolver($this);
    }

    public function getResolver(): Resolver
    {
        return $this->resolver;
    }
}