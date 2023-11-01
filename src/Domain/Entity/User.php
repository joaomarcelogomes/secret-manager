<?php

declare(strict_types=1);

namespace SecretManager\Domain\Entity;

use SecretManager\Domain\ValueObject\HashedPassword;
use SecretManager\Domain\ValueObject\Username;

readonly class User
{
  public function __construct(
    public int $id,
    public Username $username,
    public HashedPassword $password
  ) {}
}