<?php

require_once __DIR__.'/vendor/autoload.php';

(new ChatBot\Example\App\Core\Kernel(__DIR__))
  ->boot();