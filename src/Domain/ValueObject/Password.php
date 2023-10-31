<?php

declare(strict_types=1);

namespace SecretManager\Domain\ValueObject;

use DomainException;
use SecretManager\Domain\Service\PasswordHashingInterface;
use Stringable;

class Password implements Stringable
{
  public readonly string $password;

  public function __construct(string $password)
  {
    if (strlen($password) === 0) {
      throw new DomainException('InvalidPasswordSize');
    }

    if ($this->calculatePasswordStrength($password) <= 2) {
      throw new DomainException('TooWeakPassword');
    }

    $this->password = $password;
  }

  public function __toString(): string
  {
    return $this->password;
  }

  public function hash(PasswordHashingInterface $passwordHashingInterface): HashedPassword
  {
    return new HashedPassword($passwordHashingInterface->hash($this->password));
  }

  public function compare(HashedPassword $hashedPassword, PasswordHashingInterface $passwordHashingInterface): bool
  {
    return $passwordHashingInterface->compare($this->password, (string) $hashedPassword);
  }

  private function calculatePasswordStrength(string $password): int
  {
    $passwordStrength = 0;

    if (strlen($password) >= 8) {
      $passwordStrength++;
    }

    if (preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)) {
      $passwordStrength++;
    }

    if (preg_match('/[0-9]/', $password)) {
      $passwordStrength++;
    }

    if (preg_match('/[!@#$%^&*()_+{}[\]:;<>,.?~\\-]/', $password)) {
      $passwordStrength++;
    }

    return $passwordStrength;
  }
}
