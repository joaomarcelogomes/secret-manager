<?php

declare(strict_types=1);

namespace SecretManager\Domain\UseCase;

use SecretManager\Domain\Entity\EncryptedSecret;

interface SecretEncryptionInterface
{
  public function encrypt(string $value): EncryptedSecret;
  public function decrypt(EncryptedSecret $encryptedSecret): string;
}