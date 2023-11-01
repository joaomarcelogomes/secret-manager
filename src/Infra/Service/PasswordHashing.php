<?php 

declare(strict_types=1);

namespace SecretManager\Infra\Service;

use SecretManager\Domain\Service\PasswordHashingInterface;

class PasswordHashing implements PasswordHashingInterface
{
  public function hash(string $password): string
  {
    return password_hash($password, \PASSWORD_BCRYPT);
  }

  public function compare(string $password, string $hashedPassword): bool
  {
    return \password_verify($password, $hashedPassword);
  }
}