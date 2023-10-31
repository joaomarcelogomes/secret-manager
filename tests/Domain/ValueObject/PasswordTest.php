<?php

declare(strict_types=1);

namespace Tests\Domain\ValueObject;

use DomainException;
use PHPUnit\Framework\TestCase;
use SecretManager\Domain\ValueObject\Password;

class PasswordTest extends TestCase
{
  const VALID_OPTIONS = [
    'bP92)O7|S20+',
    'N289ud^G^$T8[1=Oo\'VGOw1,a2l',
  ];

  const INVALID_OPTIONS = [
    '',
    'senha',
    '123456'
  ];

  public function testWithValidOptions(): void
  {
    $detectedError = [];
    foreach(self::VALID_OPTIONS as $option) {
      try {
        new Password($option);
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
        new Password($option);
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