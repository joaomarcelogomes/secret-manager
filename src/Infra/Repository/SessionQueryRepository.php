<?php

declare(strict_types=1);

namespace SecretManager\Infra\Repository;

use DateTime;
use PDO;
use SecretManager\Domain\Entity\Session;
use SecretManager\Domain\Repository\SessionQueryRepositoryInterface;
use SecretManager\Domain\ValueObject\TerminalUser;

class SessionQueryRepository implements SessionQueryRepositoryInterface
{
  public function __construct(public readonly PDO $conn)
  {
  }

  public function findByTerminalUser(TerminalUser $terminalUser): Session
  {
    $query = "SELECT * FROM `session` WHERE `terminal_user` = :terminalUser";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':terminalUser' => $terminalUser
    ]);

    $result = $stmt->fetch(PDO::FETCH_OBJ);

    return new Session(
      $result->id,
      $result->user_id,
      DateTime::createFromFormat('Y-m-d H:i:s', $result->expires_at),
      new TerminalUser($result->terminal_user)
    );
  }
}
