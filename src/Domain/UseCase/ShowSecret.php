<?php

declare(strict_types=1);

namespace SecretManager\Domain\UseCase;

use DomainException;
use SecretManager\Domain\Repository\SecretQueryRepositoryInterface;
use SecretManager\Domain\Service\SecretEncryptionInterface;
use SecretManager\Domain\ValueObject\Secret\Hash;

class ShowSecret
{
  public function __construct(
    public SecretQueryRepositoryInterface $queryRepository,
    public SecretEncryptionInterface $encryptionInterface,
  )
  {}

  public function act(Hash $hash, int $userId)
  {
    try {
      $secret = $this->queryRepository->findByUserAndHash($userId, $hash);
    } catch (\Throwable $th) {
      \error_log($th->getMessage());
      throw new DomainException('ShowSecretInternalError');
    }

    return $this->encryptionInterface->decrypt($secret->secret, (string) $userId);
  }
}