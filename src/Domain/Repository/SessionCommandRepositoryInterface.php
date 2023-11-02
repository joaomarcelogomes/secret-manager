<?php

declare(strict_types=1);

namespace SecretManager\Domain\Repository;

use SecretManager\Domain\Entity\User;
use SecretManager\Domain\ValueObject\TerminalUser;

interface SessionCommandRepositoryInterface
{
  public function add(User $user, TerminalUser $terminalUser): void;
}