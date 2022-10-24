<?php

namespace ChatBot\Framework\DI\Resolving\Utilities;

class ParametersComputer
{
    public function computeFrom(\ReflectionFunctionAbstract $reflection): array
    {
        $params = [];

        foreach ($reflection->getParameters() as $param)
        {
            $type = $param->getType();

            if ($type instanceof \ReflectionIntersectionType || 
                $type instanceof \ReflectionUnionType ||
                is_null($type))
                throw new \LogicException('Unsupported parameter type');

            $params[] = $type;
        };

        return $params;
    }
}