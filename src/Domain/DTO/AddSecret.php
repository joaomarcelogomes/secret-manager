<?php

declare(strict_types=1);

namespace SecretManager\Domain\DTO;

use SecretManager\Domain\ValueObject\EncryptedSecret;
use SecretManager\Domain\ValueObject\Hash;
use SecretManager\Domain\ValueObject\SecretValue;

class AddSecret
{
  public function __construct(
    public int $userId,
    public Hash $hash,
    public SecretValue $secret,
    public ?EncryptedSecret $encryptedSecret = null
  ) {}
}