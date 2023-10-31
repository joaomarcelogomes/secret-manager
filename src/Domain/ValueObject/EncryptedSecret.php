<?php

declare(strict_types=1);

namespace SecretManager\Domain\ValueObject;

readonly class EncryptedSecret
{
  public function __construct(
    public string $data,
    public string $key
  )
  {}
}