<?php

namespace SecretManager\Presentation\CLI\Command\Secret;

use Minicli\Command\CommandController;

use SecretManager\Domain\{
  UseCase\ShowSecret as ShowSecretUseCase,
};
use SecretManager\Domain\ValueObject\Hash;
use SecretManager\Domain\ValueObject\TerminalUser;
use SecretManager\Infra\Provider\PDOSession;
use SecretManager\Infra\Repository\SecretQueryRepository;
use SecretManager\Infra\Repository\SessionQueryRepository;
use SecretManager\Infra\Service\SecretEncryption;

class ShowController extends CommandController
{
  public function handle(): void
  {
    $hash = $this->getParam('hash');
    $session = (new SessionQueryRepository(
      PDOSession::getConnection()
    ))->findByTerminalUser(new TerminalUser(trim(shell_exec('whoami'))));

    $showSecretUseCase = new ShowSecretUseCase(
      new SecretQueryRepository(PDOSession::getConnection()),
      new SecretEncryption
    );

    $this->display($showSecretUseCase->act(new Hash($hash), $session->userId));
  }

  public function required(): array
  {
    return ['hash'];
  }
}
