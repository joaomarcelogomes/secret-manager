<?php

declare(strict_types=1);

namespace SecretManager\Domain\DTO;

use SecretManager\Domain\ValueObject\EncryptedSecret;
use SecretManager\Domain\ValueObject\Secret\Hash;
use SecretManager\Domain\ValueObject\Secret\Value;

class AddSecret
{
  public function __construct(
    public int $userId,
    public Hash $hash,
    public Value $secret,
    public ?EncryptedSecret $encryptedSecret = null
  ) {}
}