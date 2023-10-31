<?php

declare(strict_types=1);

namespace Tests\Infra\Service;

use PHPUnit\Framework\TestCase;
use SecretManager\Domain\Service\SecretEncryptionInterface;
use SecretManager\Domain\ValueObject\EncryptedSecret;
use SecretManager\Infra\Service\SecretEncryption;

class SecretEncryptionTest extends TestCase
{
  private SecretEncryptionInterface $encryption;

  public function setUp(): void
  {
    $this->encryption = new SecretEncryption;
    parent::setUp();
  }

  public function testEncryption(): void
  {
    $this->assertInstanceOf(EncryptedSecret::class, $this->encryption->encrypt('test'));
  }

  public function testDecryption(): void
  {
    $testMessage = "Test Message";
    $encryptedData = $this->encryption->encrypt($testMessage);

    $this->assertSame($testMessage, $this->encryption->decrypt($encryptedData));
  }
}