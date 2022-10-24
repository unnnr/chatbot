<?php

namespace ChatBot\Bot\Chatting\Channel;

use ChatBot\Framework\DI\Container;
use Psr\Container\ContainerInterface;

class PrivateContainer extends Container
{
    private ContainerInterface $base;

    private Session $session;
    
    private array $temporary;
    

    public function __construct(ContainerInterface $base, Session $session)
    {
        parent::__construct();
        $this->temporary = [];
        $this->session = $session;
        $this->base = $base;
    }

    public function get(string $id): mixed
    {
        if (key_exists($id, $this->temporary))
            return $this->temporary[$id];

        if ($this->session->has($id))
            return $this->session->get($id);

        if ($this->base->has($id))
            return $this->base->get($id);

        throw new \ValueError('Can\t find service with id '. $id);
    }

    public function set(string $id, mixed $value): void
    {
        $this->temporary[$id] = $value;
    }

    public function has(string $id): bool
    {
        return key_exists($id, $this->temporary) 
            || $this->session->has($id)
            || $this->base->has($id);
    }
} 