<?php

namespace SecretManager\Presentation\CLI\Command\Secret;

use Minicli\Command\CommandController;
use Minicli\Input;

use SecretManager\Domain\{
  UseCase\AddSecret as AddSecretUseCase,
  DTO\AddSecret as AddSecretDTO,
};
use SecretManager\Domain\ValueObject\SecretValue;
use SecretManager\Domain\ValueObject\TerminalUser;
use SecretManager\Infra\Provider\PDOSession;
use SecretManager\Infra\Repository\SecretCommandRepository;
use SecretManager\Infra\Repository\SessionQueryRepository;
use SecretManager\Infra\Service\SecretEncryption;

class AddController extends CommandController
{
  public function handle(): void
  {
    $input = new Input('Name: ');
    $secretName = $input->read();

    $input = new Input('Secret: ');
    $secret = $input->read();

    $session = (new SessionQueryRepository(
      PDOSession::getConnection()
    ))->findByTerminalUser(new TerminalUser(trim(shell_exec('whoami'))));

    $addSecretDTO = new AddSecretDTO(
      $session->userId,
      $secretName,
      new SecretValue($secret)
    );

    $addSecretUseCase = new AddSecretUseCase(
      new SecretCommandRepository(PDOSession::getConnection()),
      new SecretEncryption
    );

    $addSecretUseCase->act($addSecretDTO);
    $this->display("Secret created successfully!");
  }
}
