<?php

declare(strict_types=1);

namespace SecretManager\Domain\Entity;

readonly class Secret
{
  public int $id;
  public string $secret;
  public string $key;
}