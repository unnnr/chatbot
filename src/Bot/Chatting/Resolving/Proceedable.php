<?php

namespace ChatBot\Bot\Chatting\Resolving;

use ChatBot\Bot\Chatting\Resolving\Resolvable;

abstract class Proceedable implements Resolvable
{
    public const METHOD_NAME = 'proceed';


    public final function getResolver(): callable
    {
        if (!!!method_exists($this, self::METHOD_NAME))
            throw new \LogicException('Class '. static::class . ' must have '.  self::METHOD_NAME. ' method');

        $method = new \ReflectionMethod($this, self::METHOD_NAME);
        if (!!!$method->isPublic())
            throw new \LogicException(self::METHOD_NAME . ' must be public');

        return [$this, self::METHOD_NAME];
    }
}