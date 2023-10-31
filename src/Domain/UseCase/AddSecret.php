<?php

declare(strict_types=1);

namespace SecretManager\Domain\UseCase;

use DomainException;
use SecretManager\Domain\DTO\AddSecret as AddSecretDTO;
use SecretManager\Domain\Repository\SecretCommandRepositoryInterface;

class AddSecret
{
  public function __construct(
    public SecretEncryptionInterface $encryptionInterface,
    public SecretCommandRepositoryInterface $commandRepositoryInterface,
  )
  {}

  public function act(AddSecretDTO $addSecretDTO)
  {
    $addSecretDTO->encryptedSecret = $this->encryptionInterface->encrypt((string) $addSecretDTO->secretValue);

    try {
      $this->commandRepositoryInterface->add($addSecretDTO);
    } catch (\Throwable $th) {
      \error_log($th->getMessage());
      throw new DomainException('AddSecretInternalError');
    }
  }
}