<?php

declare(strict_types=1);

namespace Tests\Infra\Service;

use PHPUnit\Framework\TestCase;
use SecretManager\Domain\Service\PasswordHashingInterface;
use SecretManager\Infra\Service\PasswordHashing;

class PasswordHashingTest extends TestCase
{
  private PasswordHashingInterface $hashingInterface;

  public function setUp(): void
  {
    $this->hashingInterface = new PasswordHashing;
    parent::setUp();
  }

  public function testHashing(): void
  {
    $testPassword = "test";
    $this->assertNotEquals($testPassword, $this->hashingInterface->hash($testPassword));
  }

  public function testComparison(): void
  {
    $hashedPassword = $this->hashingInterface->hash('test');

    $this->assertTrue($this->hashingInterface->compare('test', $hashedPassword));
  }

  public function testInvalidComparison(): void
  {
    $hashedPassword = $this->hashingInterface->hash('test');

    $this->assertFalse($this->hashingInterface->compare('123456', $hashedPassword));
  }
}