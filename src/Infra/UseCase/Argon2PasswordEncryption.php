<?php 

declare(strict_types=1);

namespace SecretManager\Infra\UseCase;

use SecretManager\Domain\UseCase\PasswordEncryptionInterface;

class Argon2PasswordEncryption implements PasswordEncryptionInterface
{
  public function encrypt(string $password): string
  {
    return password_hash($password, \PASSWORD_ARGON2I);
  }

  public function compare(string $rawPassword, string $encryptedPassword): bool
  {
    return \password_verify($rawPassword, $encryptedPassword);
  }
}