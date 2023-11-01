<?php 

declare(strict_types=1);

namespace SecretManager\Infra\Repository;

use PDO;
use SecretManager\Domain\Entity\User;
use SecretManager\Domain\Repository\UserQueryRepositoryInterface;
use SecretManager\Domain\ValueObject\HashedPassword;
use SecretManager\Domain\ValueObject\Username;

class UserQueryRepository implements UserQueryRepositoryInterface
{
  public function __construct(public readonly PDO $conn)
  {}

  public function findByUsername(Username $username): User
  {
    $query = "SELECT * FROM `user` WHERE `username` = :username";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':username' => $username
    ]);

    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return new User(
      $result->id,
      new Username($result->username),
      new HashedPassword($result->password)
    );
  }
}