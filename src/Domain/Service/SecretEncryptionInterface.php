<?php

declare(strict_types=1);

namespace SecretManager\Domain\Service;

use SecretManager\Domain\ValueObject\EncryptedSecret;

interface SecretEncryptionInterface
{
  public function encrypt(string $value): EncryptedSecret;
  public function decrypt(EncryptedSecret $encryptedSecret): string;
}