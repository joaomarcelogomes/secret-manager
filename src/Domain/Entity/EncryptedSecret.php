<?php

declare(strict_types=1);

namespace SecretManager\Domain\Entity;

readonly class EncryptedSecret
{
  public function __construct(
    public string $cipherText,
    public string $key
  )
  {}
}