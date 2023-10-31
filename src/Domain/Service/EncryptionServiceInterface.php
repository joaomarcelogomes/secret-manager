<?php

namespace SecretManager\Domain\Service;

use SecretManager\Domain\Entity\EncryptedData;

interface EncryptionServiceInterface
{
  public function encrypt(string $value): EncryptedData;
  public function decrypt(EncryptedData $encryptedData): string;
}