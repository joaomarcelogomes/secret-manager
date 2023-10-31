<?php

declare(strict_types=1);

namespace SecretManager\Domain\Repository;

use SecretManager\Domain\ValueObject\HashedPassword;
use SecretManager\Domain\ValueObject\Username;

interface UserCommandRepositoryInterface
{
  public function add(Username $username, HashedPassword $hashedPassword): void;
}