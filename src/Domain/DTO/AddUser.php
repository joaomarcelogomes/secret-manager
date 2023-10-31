<?php

declare(strict_types=1);

namespace SecretManager\Domain\DTO;

use SecretManager\Domain\VO\{Username, Password};

class AddUser
{
  public function __construct(
    public Username $username,
    public Password $password
  ) {}
}