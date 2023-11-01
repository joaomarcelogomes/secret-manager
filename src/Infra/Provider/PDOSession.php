<?php

namespace SecretManager\Infra\Provider;

use PDO;

class PDOSession
{
  private static $instance = null;
  private $pdo;

  private function __construct()
  {
    $driver = getenv('DB_DRIVER');
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $username = getenv('DB_USER');
    $password = getenv('DB_PASS');

    $this->pdo = new PDO("{$driver}:host={$host};dbname={$dbname}", $username, $password);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  private static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  public static function getConnection()
  {
    $instance = self::getInstance();
    return $instance->pdo;
  }
}
