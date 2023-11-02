<?php

declare(strict_types=1);

namespace SecretManager\Domain\Repository;

use SecretManager\Domain\Entity\Session;
use SecretManager\Domain\ValueObject\TerminalUser;

interface SessionQueryRepositoryInterface
{
  public function findByTerminalUser(TerminalUser $terminalUser): Session;
}
