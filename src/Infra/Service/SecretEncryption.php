<?php

declare(strict_types=1);

namespace SecretManager\Infra\Service;

use SecretManager\Domain\Service\SecretEncryptionInterface;
use SecretManager\Domain\ValueObject\EncryptedSecret;

class SecretEncryption implements SecretEncryptionInterface
{
  private const CIPHER = 'AES-256-CBC';
  public function encrypt(string $data, string $password): EncryptedSecret
  {
    $salt      = random_bytes(16);
    $key       = hash_pbkdf2("sha256", $password, $salt, 1000, 32);
    $iv        = random_bytes(16);
    $encrypted = openssl_encrypt($data, self::CIPHER, $key, 0, $iv);

    return new EncryptedSecret(\base64_encode("{$salt}{$iv}{$encrypted}"), $key);
  }

  public function decrypt(EncryptedSecret $encryptedSecret, string $password): string
  {
    $data = base64_decode($encryptedSecret->data);
    $salt = substr($data, 0, 16);
    $iv = substr($data, 16, 16);
    $encrypted = substr($data, 32);
    $key = hash_pbkdf2("sha256", $password, $salt, 1000, 32);

    return openssl_decrypt($encrypted, self::CIPHER, $key, 0, $iv) ?: "";
  }

}