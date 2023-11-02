<?php

declare(strict_types=1);

namespace SecretManager\Domain\Repository;

use SecretManager\Domain\Entity\Secret;
use SecretManager\Domain\ValueObject\Secret\Hash;

interface SecretQueryRepositoryInterface
{
  public function findByUserAndHash(int $userId, Hash $hash): Secret;
}
