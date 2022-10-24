<?php

namespace ChatBot\Framework\DI\Containers;

use Symfony\Component\DependencyInjection\ContainerInterface;
use ChatBot\Framework\DI\Container;

class SymfonyContainer extends Container
{
    public function __construct(
        private ContainerInterface $baseContainer
    ) {
        parent::__construct();
    }

    public function get(string $id): mixed
    {
        return $this->baseContainer->get($id);
    }

    public function has(string $id): bool
    {
        return $this->baseContainer->has($id);
    }

    public function set(string $id, mixed $value): void
    {
        $this->baseContainer->set($id, $value);
    }
}