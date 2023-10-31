<?php

declare(strict_types=1);

namespace SecretManager\Domain\UseCase;

interface PasswordEncryptionInterface
{
  public function encrypt(string $password): string;
  public function compare(string $rawPassword, string $encryptedPassword): bool;
}