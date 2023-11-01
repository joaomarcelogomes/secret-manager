<?php 

declare(strict_types=1);

namespace SecretManager\Infra\Repository;

use PDO;
use SecretManager\Domain\Repository\UserCommandRepositoryInterface;
use SecretManager\Domain\ValueObject\HashedPassword;
use SecretManager\Domain\ValueObject\Username;

class UserCommandRepository implements UserCommandRepositoryInterface
{
  public function __construct(public readonly PDO $conn)
  {}

  public function add(Username $username, HashedPassword $hashedPassword): void
  {
    $query = "INSERT IGNORE INTO `user` (`username`, `password`) VALUES (:username, :password)";
    $stmt = $this->conn->prepare($query);

    $stmt->execute([
      'username' => $username,
      'password' => $hashedPassword
    ]);
  }
}