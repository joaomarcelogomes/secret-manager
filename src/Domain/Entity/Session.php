<?php

declare(strict_types=1);

namespace SecretManager\Domain\Entity;

use DateTimeInterface;
use SecretManager\Domain\ValueObject\TerminalUser;

readonly class Session
{
  public function __construct(
    public int $id,
    public int $userId,
    public DateTimeInterface $expiresAt,
    public TerminalUser $terminalUser
  ) {}
}