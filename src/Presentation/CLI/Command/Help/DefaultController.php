<?php

namespace SecretManager\Presentation\CLI\Command\Help;

use Minicli\App;
use Minicli\Command\CommandCall;
use Minicli\Command\CommandController;

class DefaultController extends CommandController
{
  /** @var  array */
  protected $commandMap = [];

  public function boot(App $app, CommandCall $input): void
  {
    parent::boot($app, $input);
    $this->commandMap = $app->commandRegistry->getCommandMap();
  }

  public function handle(): void
  {
    $this->app->info('Available Commands');

    foreach ($this->commandMap as $command => $sub) {
      $this->app->newline();
      $this->app->out($command);

      if (is_array($sub)) {
        foreach ($sub as $subcommand) {
          if ($subcommand !== 'default') {
            $this->app->newline();
            $this->app->out(sprintf('%s%s', '└──', $subcommand));
          }
        }
      }
      $this->app->newline();
    }

    $this->app->newline();
  }
}
