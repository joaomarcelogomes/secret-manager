<?php

declare(strict_types=1);

use SecretManager\Domain\DTO\AddUser as AddUserDTO;

interface UserCommandRepositoryInterface
{
  public function add(AddUserDTO $userDTO): void;
}