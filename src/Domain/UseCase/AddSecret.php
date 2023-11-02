<?php

declare(strict_types=1);

namespace SecretManager\Domain\UseCase;

use DomainException;
use SecretManager\Domain\DTO\AddSecret as AddSecretDTO;
use SecretManager\Domain\Repository\SecretCommandRepositoryInterface;
use SecretManager\Domain\Service\SecretEncryptionInterface;

class AddSecret
{
  public function __construct(
    public SecretCommandRepositoryInterface $commandRepositoryInterface,
    public SecretEncryptionInterface $encryptionInterface,
  )
  {}

  public function act(AddSecretDTO $addSecretDTO)
  {
    $addSecretDTO->encryptedSecret = $this->encryptionInterface->encrypt(
      (string) $addSecretDTO->secret,
      (string) $addSecretDTO->userId
    );

    try {
      $this->commandRepositoryInterface->add($addSecretDTO);
    } catch (\Throwable $th) {
      \error_log($th->getMessage());
      throw new DomainException('AddSecretInternalError');
    }
  }
}