<?php

declare(strict_types=1);

namespace SecretManager\Domain\ValueObject;

use DomainException;
use Stringable;

class Hash implements Stringable
{
  public readonly string $hash;

  public function __construct(string $hash)
  {
    if (strlen($hash) <= 0 || strlen($hash) > 30 || !preg_match('/^[a-z0-9\._\-]{1,20}$/', $hash)) {
      throw new DomainException('InvalidSecretHash');
    }

    $this->hash = $hash;
  }

  public function __toString(): string
  {
    return $this->hash;
  }
}
