<?php

declare(strict_types=1);

namespace Tests\Infra\UseCase;

use PHPUnit\Framework\TestCase;
use SecretManager\Domain\UseCase\SecretEncryptionInterface;
use SecretManager\Domain\Entity\EncryptedData;
use SecretManager\Infra\UseCase\ChaCha20SecretEncryption;

class ChaCha20SecretEncryptionTest extends TestCase
{
  private SecretEncryptionInterface $encryption;

  public function setUp(): void
  {
    $this->encryption = new ChaCha20SecretEncryption;
    parent::setUp();
  }

  public function testEncryption(): void
  {
    $this->assertInstanceOf(EncryptedData::class, $this->encryption->encrypt('test'));
  }

  public function testDecryption(): void
  {
    $testMessage = "Test Message";
    $encryptedData = $this->encryption->encrypt($testMessage);

    $this->assertSame($testMessage, $this->encryption->decrypt($encryptedData));
  }
}