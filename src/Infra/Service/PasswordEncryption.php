<?php 

declare(strict_types=1);

namespace SecretManager\Infra\Service;

use SecretManager\Domain\Service\PasswordEncryptionInterface;

class PasswordEncryption implements PasswordEncryptionInterface
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