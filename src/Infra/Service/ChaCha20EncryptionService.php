<?php

namespace SecretManager\Infra\Service;

use SecretManager\Domain\Entity\EncryptedData;
use SecretManager\Domain\Service\EncryptionServiceInterface;

class ChaCha20EncryptionService implements EncryptionServiceInterface
{
  public function encrypt(string $value): EncryptedData
  {
    $key = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_KEYBYTES);
    $nonce = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_NPUBBYTES);

    $encryptedValue = sodium_crypto_aead_chacha20poly1305_encrypt($value, '', $nonce, $key);
    return new EncryptedData($encryptedValue, $this->unifyKeyAndNonce($key, $nonce));
  }

  private function unifyKeyAndNonce(string $key, string $nonce) {
    return base64_encode("{$key}:{$nonce}");
  }

  private function explodeKeyAndNonce(string $unifiedKey): array {
    $keyAndNonce = \base64_decode($unifiedKey);
    return explode(':', $keyAndNonce);
  }

  public function decrypt(EncryptedData $encryptedData): string
  {
    [$key, $nonce] = $this->explodeKeyAndNonce($encryptedData->key);
    return sodium_crypto_aead_chacha20poly1305_decrypt($encryptedData->cipherText, '', $nonce, $key);
  }

}