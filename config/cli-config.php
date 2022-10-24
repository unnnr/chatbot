<?php

require 'vendor/autoload.php';


$kernel = new \ChatBot\Migrator\MigratorKernel(dirname(__DIR__));
$kernel->boot();

return $kernel->getContainer()
    ->get(Doctrine\Migrations\DependencyFactory::class);