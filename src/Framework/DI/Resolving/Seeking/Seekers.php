<?php

namespace ChatBot\Framework\DI\Resolving\Seeking;

use ChatBot\Framework\DI\Resolving\Utilities\ParametersComputer;
use ChatBot\Framework\DI\Resolving\Utilities\DependencyResolver;
use Psr\Container\ContainerInterface;

class Seekers
{
    private FunctionSeeker $functionSeeker;

    private MethodSeeker $methodSeeker;


    public function __construct(ContainerInterface $container)
    {
        $resolver = new DependencyResolver($container);
        $parameters = new ParametersComputer();

        $this->methodSeeker = new MethodSeeker($parameters, $resolver);
        $this->functionSeeker = new FunctionSeeker($parameters, $resolver);
    }
    
    public function getFunctionSeeker(): FunctionSeeker
    {
        return $this->functionSeeker;
    }

    public function getMethodSeeker(): MethodSeeker
    {
        return $this->methodSeeker;
    }
}