<?php

namespace ChatBot\Shared\Dependencies;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use ChatBot\Framework\DI\Dependency;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;;

class DoctrineDependency extends Dependency
{
    public function process(ContainerBuilder $container)
    {
        $factory = function () use ($container) {
            $connection = [
                'user' => $container->getParameter('doctrine.connection.user'),
                'driver' => $container->getParameter('doctrine.connection.driver'),
                'dbname' => $container->getParameter('doctrine.connection.dbname'),
                'password' => $container->getParameter('doctrine.connection.password'),
            ];

            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [$container->getParameter('doctrine.orm.entites_dir')],
                isDevMode: $container->getParameter('app.devmode')
            );

            return EntityManager::create($connection, $config);
        };

        $container->register(EntityManager::class, EntityManager::class)
            ->setPublic(true)
            ->setFactory('call_user_func')
            ->setArguments([$factory]);
    }
}