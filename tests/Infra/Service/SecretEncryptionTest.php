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
    $password = "123456";
    $this->assertInstanceOf(EncryptedSecret::class, $this->encryption->encrypt('test', $password));
  }

  public function testDecryption(): void
  {
    $testSecret = "Test Message";
    $password = "123456";
    $encryptedData = $this->encryption->encrypt($testSecret, $password);

    $this->assertSame($testSecret, $this->encryption->decrypt($encryptedData, $password));
  }
}