<?php

declare(strict_types=1);

namespace SecretManager\Domain\UseCase;

use DomainException;
use SecretManager\Domain\DTO\CreateSession as CreateSessionDTO;
use SecretManager\Domain\Repository\SessionCommandRepositoryInterface;
use SecretManager\Domain\Repository\UserQueryRepositoryInterface;
use SecretManager\Domain\Service\PasswordHashingInterface;

class CreateSession
{
  public function __construct(
    public SessionCommandRepositoryInterface $commandRepositoryInterface,
    public UserQueryRepositoryInterface $userQueryRepositoryInterface,
    public PasswordHashingInterface $passwordHashingInterface
  )
  {}

  public function act(CreateSessionDTO $createSessionDTO)
  {
    $user = $this->userQueryRepositoryInterface->findByUsername($createSessionDTO->username);
    if (!$createSessionDTO->password->compare($user->password, $this->passwordHashingInterface)) {
      throw new DomainException('InvalidPassword');
    }

    try {
      $this->commandRepositoryInterface->add($user, $createSessionDTO->terminalUser);
    } catch (\Throwable $th) {
      \error_log($th->getMessage());
      throw new DomainException('AddUserInternalError');
    }
  }
}