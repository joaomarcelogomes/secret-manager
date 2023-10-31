<?php

declare(strict_types=1);

namespace Tests\Infra\Service;

use PHPUnit\Framework\TestCase;
use SecretManager\Domain\Service\EncryptionServiceInterface;
use SecretManager\Domain\Entity\EncryptedData;
use SecretManager\Infra\Service\ChaCha20EncryptionService;

class ChaCha20EncryptionServiceTest extends TestCase
{
  private EncryptionServiceInterface $encryptionService;

  public function setUp(): void
  {
    $this->encryptionService = new ChaCha20EncryptionService;
    parent::setUp();
  }

  public function testEncryption(): void
  {
    $this->assertInstanceOf(EncryptedData::class, $this->encryptionService->encrypt('test'));
  }

  public function testDecryption(): void
  {
    $testMessage = "Test Message";
    $encryptedData = $this->encryptionService->encrypt($testMessage);

    $this->assertSame($testMessage, $this->encryptionService->decrypt($encryptedData));
  }
}