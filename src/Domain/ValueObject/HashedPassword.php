<?php

declare(strict_types=1);

namespace SecretManager\Domain\ValueObject;

use Stringable;

class HashedPassword implements Stringable
{
  public readonly string $hash;

  public function __construct(string $hash)
  {
    $this->hash = $hash;
  }

  public function __toString(): string
  {
    return $this->hash;
  }
}
