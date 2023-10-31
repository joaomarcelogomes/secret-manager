<?php 

declare(strict_types=1);

namespace SecretManager\Infra\Secret;

use PDO;
use SecretManager\Domain\DTO\AddSecret;
use SecretManager\Domain\Repository\SecretCommandRepositoryInterface;

class SecretCommandRepository implements SecretCommandRepositoryInterface
{
  public function __construct(public readonly PDO $conn)
  {}

  public function add(AddSecret $addSecretDTO): void
  {
    $query = "INSERT IGNORE INTO `secret` ('user_id', 'secret', 'key') VALUES (:userId, :secret, :key)";
    $stmt = $this->conn->prepare($query);

    $stmt->execute([
      'userId' => $addSecretDTO->userId,
      'secret' => $addSecretDTO->encryptedSecret->cipherText,
      'key' => $addSecretDTO->encryptedSecret->key
    ]);
  }
}