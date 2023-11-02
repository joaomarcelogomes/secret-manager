<?php

declare(strict_types=1);

namespace SecretManager\Infra\Repository;

use DateTime;
use PDO;
use SecretManager\Domain\Entity\Secret;
use SecretManager\Domain\Repository\SecretQueryRepositoryInterface;
use SecretManager\Domain\ValueObject\EncryptedSecret;
use SecretManager\Domain\ValueObject\Hash;
use SecretManager\Domain\ValueObject\TerminalUser;

class SecretQueryRepository implements SecretQueryRepositoryInterface
{
  public function __construct(public readonly PDO $conn)
  {
  }

  public function findByUserAndHash(int $userId, Hash $hash): Secret
  {
    $query = "SELECT * FROM `secret` WHERE `user_id` = :userId AND `hash` = :hash";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      'userId' => $userId,
      'hash' => $hash
    ]);

    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return new Secret(
      $result->id,
      $result->user_id,
      new Hash($result->hash),
      new EncryptedSecret($result->secret, $result->key),
      $result->key
    );
  }
}
