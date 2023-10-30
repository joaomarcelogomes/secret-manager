<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use DomainException;
use PHPUnit\Framework\TestCase;
use SecretManager\Domain\ValueObject\Username;

class UsernameTest extends TestCase
{
  const VALID_OPTIONS = [
    'username',
    'user_name',
    'user.name'
  ];

  const INVALID_OPTIONS = [
    'u$3rN4me',
    'USERNAME',
    '',
    'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
  ];

  public function testWithValidOptions(): void
  {
    $detectedError = [];
    foreach(self::VALID_OPTIONS as $option) {
      try {
        new Username($option);
      } catch (DomainException $th) {
        $detectedError[] = $option;
      }
    }

    if (!empty($detectedError)) {
      print_r($detectedError);
    }

    $this->assertEmpty($detectedError);
  }

  public function testWithInvalidOptions(): void
  {
    $notDetectedError = [];
    foreach(self::INVALID_OPTIONS as $option) {
      try {
        new Username($option);
        $notDetectedError[] = $option;
      } catch (DomainException $th) {
        continue;
      }
    }

    if (!empty($notDetectedError)) {
      print_r($notDetectedError);
    }

    $this->assertEmpty($notDetectedError);
  }
}