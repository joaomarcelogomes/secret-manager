#!/usr/bin/env php
<?php

if (php_sapi_name() !== 'cli') {
  exit;
}

require __DIR__ . '/../../../vendor/autoload.php';

use Minicli\App;
use Minicli\Exception\CommandNotFoundException;
use SecretManager\Infra\Environment;

$app = new App([
  'app_path' => [
    __DIR__ . '/Command',
  ],
  'theme' => '\Dracula'
]);

try {
  (new Environment)->load(__DIR__ . '/../../../');
  $app->runCommand($argv);
} catch (CommandNotFoundException $th) {
  $app->error('An error occurred running the command: ' . $th->getMessage());
}
