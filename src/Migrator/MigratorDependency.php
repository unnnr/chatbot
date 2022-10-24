<?php

namespace ChatBot\Migrator;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManager;
use ChatBot\Framework\DI\Dependency;

class MigratorDependency extends Dependency
{
    public function process(ContainerBuilder $container): void
    {
        $factory = function () use ($container) {
            $config = new ConfigurationArray([
                'table_storage' => [
                    'table_name' => 'doctrine_migration_versions',
                    'version_column_name' => 'version',
                    'version_column_length' => 1024,
                    'executed_at_column_name' => 'executed_at',
                    'execution_time_column_name' => 'execution_time',
                ],
            
            
                'migrations_paths' => [
                    'Migrations'=> 
                        $container->getParameter('doctrine.migrations.dir')
                ],
            
                'all_or_nothing' => true,
                'transactional' => true,
                'check_database_platform' => true,
                'organize_migrations' => 'none',
            
                'connection' => null,
                'em' => null
            ]);


            return DependencyFactory::fromEntityManager(
                $config,
                new ExistingEntityManager($container->get(EntityManager::class))
            );
        };

        $container->register(DependencyFactory::class, DependencyFactory::class)
            ->setPublic(true)
            ->setFactory('call_user_func')
            ->setArguments([$factory]);
    }
}