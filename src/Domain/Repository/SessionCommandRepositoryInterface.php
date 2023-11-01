<?php

declare(strict_types=1);

namespace SecretManager\Domain\Repository;

use SecretManager\Domain\Entity\User;

interface SessionCommandRepositoryInterface
{
  public function add(User $user): void;
}