<?php

declare(strict_types=1);

namespace SecretManager\Infra\UseCase;

use SecretManager\Domain\Entity\EncryptedSecret;
use SecretManager\Domain\UseCase\SecretEncryptionInterface;

class ChaCha20SecretEncryption implements SecretEncryptionInterface
{
  public function encrypt(string $value): EncryptedSecret
  {
    $key = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_KEYBYTES);
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_NPUBBYTES);

    $encryptedValue = sodium_crypto_aead_chacha20poly1305_encrypt($value, '', $nonce, $key);
    return new EncryptedSecret($encryptedValue, $this->unifyKeyAndNonce($key, $nonce));
  }

  private function unifyKeyAndNonce(string $key, string $nonce) {
    return base64_encode("{$key}:{$nonce}");
  }

  private function explodeKeyAndNonce(string $unifiedKey): array {
    $keyAndNonce = \base64_decode($unifiedKey);
    return explode(':', $keyAndNonce);
  }

  public function decrypt(EncryptedSecret $encryptedSecret): string
  {
    [$key, $nonce] = $this->explodeKeyAndNonce($encryptedSecret->key);
    return sodium_crypto_aead_chacha20poly1305_decrypt($encryptedSecret->cipherText, '', $nonce, $key);
  }

}