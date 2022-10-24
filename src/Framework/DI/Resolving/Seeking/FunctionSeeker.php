<?php

namespace ChatBot\Framework\DI\Resolving\Seeking;

use ChatBot\Framework\DI\Resolving\Utilities\ParametersComputer;
use ChatBot\Framework\DI\Resolving\Utilities\DependencyResolver;

class FunctionSeeker
{
    public function __construct(
        private ParametersComputer $parameters,
        private DependencyResolver $dependecies
    ) {}
    
    public function seekIn(callable $callable): array
    {
        $reflection = new \ReflectionFunction($callable);

        return $this->dependecies->resolve(
            names: $this->parameters->computeFrom($reflection)
        );
    }
}