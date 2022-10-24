<?php

namespace ChatBot\Framework\DI\Resolving\Seeking;

use ChatBot\Framework\DI\Resolving\Utilities\ParametersComputer;
use ChatBot\Framework\DI\Resolving\Utilities\DependencyResolver;

class MethodSeeker
{
    public function __construct(
        private ParametersComputer $parameters,
        private DependencyResolver $dependecies
    ) {}
    
    public function seekIn(string|object $class, string $method): array
    {
        $reflection = new \ReflectionMethod($class, $method);

        return $this->dependecies->resolve(
            names: $this->parameters->computeFrom($reflection)
        );
    }
}