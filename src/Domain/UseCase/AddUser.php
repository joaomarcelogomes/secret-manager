<?php

declare(strict_types=1);

namespace SecretManager\Domain\UseCase;

use DomainException;
use SecretManager\Domain\DTO\AddUser as AddUserDTO;
use SecretManager\Domain\Repository\UserCommandRepositoryInterface;
use SecretManager\Domain\Service\PasswordHashingInterface;

class AddUser
{
  public function __construct(
    public UserCommandRepositoryInterface $commandRepositoryInterface,
    public PasswordHashingInterface $passwordHashingInterface
  )
  {}

  public function act(AddUserDTO $addUserDTO)
  {
    try {
      $this->commandRepositoryInterface->add(
        $addUserDTO->username,
        $addUserDTO->password->hash($this->passwordHashingInterface)
      );
    } catch (\Throwable $th) {
      \error_log($th->getMessage());
      throw new DomainException('AddUserInternalError');
    }
  }
}