<?php

declare(strict_types=1);

namespace SecretManager\Domain\Entity;

use SecretManager\Domain\ValueObject\EncryptedSecret;
use SecretManager\Domain\ValueObject\Secret\Hash;

readonly class Secret
{
  public function __construct(
    public int $id,
    public int $userId,
    public Hash $hash,
    public EncryptedSecret $secret,
    public string $key,
  )
  {
  }
}