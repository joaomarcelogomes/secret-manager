<?php 

declare(strict_types=1);

namespace SecretManager\Infra\Repository;

use DateTime;
use PDO;
use SecretManager\Domain\Entity\User;
use SecretManager\Domain\Repository\SessionCommandRepositoryInterface;
use SecretManager\Domain\ValueObject\TerminalUser;

class SessionCommandRepository implements SessionCommandRepositoryInterface
{
  public function __construct(public readonly PDO $conn)
  {}

  public function add(User $user, TerminalUser $terminalUser): void
  {
    $query = "INSERT IGNORE INTO `session` (`user_id`, `terminal_user`, `expires_at`) VALUES (:userId, :terminalUser, :expireDate)";
    $stmt = $this->conn->prepare($query);

    $stmt->execute([
      'userId'       => $user->id,
      'terminalUser' => $terminalUser,
      'expireDate'   => (new DateTime('+10 minutes'))->format('Y-m-d H:i:s')
    ]);
  }
}