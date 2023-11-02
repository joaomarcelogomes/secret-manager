<?php

declare(strict_types=1);

namespace SecretManager\Domain\DTO;

use SecretManager\Domain\ValueObject\Password;
use SecretManager\Domain\ValueObject\TerminalUser;
use SecretManager\Domain\ValueObject\Username;

class CreateSession
{
  public function __construct(
    public Username $username,
    public Password $password,
    public TerminalUser $terminalUser
  ) {}
}