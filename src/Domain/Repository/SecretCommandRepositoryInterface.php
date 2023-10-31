<?php

declare(strict_types=1);

namespace SecretManager\Domain\Repository;

use SecretManager\Domain\DTO\AddSecret as AddSecretDTO;

interface SecretCommandRepositoryInterface
{
  public function add(AddSecretDTO $addSecretDTO): void;
}