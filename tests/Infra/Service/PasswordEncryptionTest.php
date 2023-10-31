<?php

declare(strict_types=1);

namespace Tests\Infra\Service;

use PHPUnit\Framework\TestCase;
use SecretManager\Domain\Service\PasswordEncryptionInterface;
use SecretManager\Infra\Service\PasswordEncryption;

class PasswordEncryptionTest extends TestCase
{
  private PasswordEncryptionInterface $encryption;

  public function setUp(): void
  {
    $this->encryption = new PasswordEncryption;
    parent::setUp();
  }

  public function testEncryption(): void
  {
    $testPassword = "test";
    $this->assertNotEquals($testPassword, $this->encryption->encrypt($testPassword));
  }

  public function testComparation(): void
  {
    $testMessage = "test";
    $encryptedPassword = $this->encryption->encrypt($testMessage);

    $this->assertTrue($this->encryption->compare($testMessage, $encryptedPassword));
  }
}