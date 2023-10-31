<?php

declare(strict_types=1);

namespace SecretManager\Domain\Service;

interface PasswordHashingInterface
{
  public function hash(string $password): string;
  public function compare(string $password, string $hashedPassword): bool;
}