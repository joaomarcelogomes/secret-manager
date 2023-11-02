<?php

declare(strict_types=1);

namespace SecretManager\Domain\ValueObject;

use DomainException;
use Stringable;

class SecretValue implements Stringable
{
  public readonly string $secretValue;

  public function __construct(string $secretValue)
  {
    if (strlen($secretValue) <= 0 || strlen($secretValue) > 255) {
      throw new DomainException('InvalidSecretValueSize');
    }

    $this->secretValue = $secretValue;
  }

  public function __toString(): string
  {
    return $this->secretValue;
  }
}
