<?php

namespace ChatBot\Framework\Config;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

class ConfigLoader
{
    private string $rootDir;


    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function loadTo(ContainerBuilder $container): void
    {
        $params = $this->scanFiles();

        $this->defineParams($container, $params);
    }

    private function scanFiles(): array
    {
        $config = [];
        $dir = $this->rootDir.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR;

        foreach (glob($dir.'*.yaml') as $path) {
            $newConfig = Yaml::parse(file_get_contents($path));            
            $config = array_merge($config, $newConfig);
        }

        return $config;
    }

    private function defineParams(ContainerBuilder $container, array $params, string $prefix = ''): void
    {
        $container->setParameter('app.project_dir', $this->rootDir);

        foreach ($params as $key => $value) {
            if (is_array($value))
                $this->defineParams($container, $value, $prefix.$key.'.' );
            else
                $container->setParameter($prefix.$key, $value);
        };
    }
}