<?php

declare(strict_types=1);

namespace SecretManager\Infra\Service;

use SecretManager\Domain\Service\SecretEncryptionInterface;
use SecretManager\Domain\ValueObject\EncryptedSecret;

class SecretEncryption implements SecretEncryptionInterface
{
  private const CIPHER = 'AES-256-CBC';
  public function encrypt(string $data): EncryptedSecret
  {
    $iv = random_bytes(16);
    $key = random_bytes(32);
    $encryptedData = openssl_encrypt($data, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);

    return new EncryptedSecret(\base64_encode("{$iv}{$encryptedData}"), $key);
  }

  public function decrypt(EncryptedSecret $encryptedSecret): string
  {
    $encryptedData = \base64_decode($encryptedSecret->data);
    $iv = \substr($encryptedData, 0, 16);
    $data = \substr($encryptedData, 16);

    return openssl_decrypt($data, self::CIPHER, $encryptedSecret->key, OPENSSL_RAW_DATA, $iv) ?: "";
  }

}