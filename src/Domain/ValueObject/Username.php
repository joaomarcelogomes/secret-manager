<?php

declare(strict_types=1);

namespace SecretManager\Domain\ValueObject;

use DomainException;
use Stringable;

class Username implements Stringable
{

  public readonly string $username;

  public function __construct(string $username)
  {
    // EXPECT: username | user.name | user_name
    if (!preg_match('/^[a-z\._]{1,20}$/', $username)) {
      throw new DomainException('InvalidUsername');
    }

    $this->username = $username;
  }

  public function __toString(): string
  {
    return $this->username;
  }
}