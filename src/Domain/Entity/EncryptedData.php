<?php

namespace SecretManager\Domain\Entity;

readonly class EncryptedData
{
  public function __construct(
    public string $cipherText,
    public string $key
  )
  {}
}