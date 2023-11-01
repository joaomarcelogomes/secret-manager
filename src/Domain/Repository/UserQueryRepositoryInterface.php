<?php

declare(strict_types=1);

namespace SecretManager\Domain\Repository;

use SecretManager\Domain\Entity\User;
use SecretManager\Domain\ValueObject\Username;

interface UserQueryRepositoryInterface
{
  public function findByUsername(Username $username): User;
}