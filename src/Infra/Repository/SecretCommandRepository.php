<?php 

declare(strict_types=1);

namespace SecretManager\Infra\Repository;

use PDO;
use SecretManager\Domain\DTO\AddSecret;
use SecretManager\Domain\Repository\SecretCommandRepositoryInterface;

class SecretCommandRepository implements SecretCommandRepositoryInterface
{
  public function __construct(public readonly PDO $conn)
  {}

  public function add(AddSecret $addSecretDTO): void
  {
    $query = "INSERT IGNORE INTO `secret` (`hash`, `user_id`, `secret`, `key`) VALUES (:hash, :userId, :secret, :key)";
    $stmt = $this->conn->prepare($query);

    $stmt->execute([
      'hash' => $addSecretDTO->hash,
      'userId' => $addSecretDTO->userId,
      'secret' => $addSecretDTO->encryptedSecret->data,
      'key' => $addSecretDTO->encryptedSecret->key
    ]);
  }
}