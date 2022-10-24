<?php

namespace ChatBot\Framework\Config;

use Symfony\Component\Dotenv\Dotenv;

class EnvLoader
{
    public function __construct(
        private string $rootDir
    ) {}

    public function load(): void
    {
        $filepath = $this->rootDir . DIRECTORY_SEPARATOR . '.env';
        if (!!!file_exists($filepath)) {
            $this->throwWarning();
            return;
        }

        (new Dotenv())->load($filepath);
    }

    private function throwWarning(): void
    {
        trigger_error(
            message: '.env has\'n been found at '. $this->rootDir,
            error_level:  E_USER_WARNING
        );
    }
}