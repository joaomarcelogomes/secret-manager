<?php

declare(strict_types=1);

namespace SecretManager\Domain\ValueObject;

use DomainException;
use Stringable;

class TerminalUser implements Stringable
{
  public readonly string $user;

  public function __construct(string $user)
  {
    if (strlen($user) < 3 || strlen($user) > 32 || !ctype_alpha($user[0])) {
      throw new DomainException('InvalidTerminalUser');
    }

    $this->user = $user;
  }

  public function __toString(): string
  {
    return (string) $this->user;
  }
}