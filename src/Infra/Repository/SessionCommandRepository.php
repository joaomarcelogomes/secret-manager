<?php 

declare(strict_types=1);

namespace SecretManager\Infra\Repository;

use DateTime;
use PDO;
use SecretManager\Domain\Entity\User;
use SecretManager\Domain\Repository\SessionCommandRepositoryInterface;

class SessionCommandRepository implements SessionCommandRepositoryInterface
{
  public function __construct(public readonly PDO $conn)
  {}

  public function add(User $user): void
  {
    $query = "INSERT IGNORE INTO `session` (`user_id`, `expires_at`) VALUES (:userId, :expireDate)";
    $stmt = $this->conn->prepare($query);

    $stmt->execute([
      'userId'     => $user->id,
      'expireDate' => (new DateTime('+10 minutes'))->format('Y-m-d H:i:s')
    ]);
  }
}