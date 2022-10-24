<?php

namespace ChatBot\Migrator;

use ChatBot\Framework\Kernel;

class MigratorKernel extends Kernel
{
    public function getAppClass(): ?string
    {
        return null;
    }

    public function getAppDependencies(): array
    {
        return [
            \ChatBot\Shared\Dependencies\DoctrineDependency::class,
            \ChatBot\Migrator\MigratorDependency::class
        ];
    }
}