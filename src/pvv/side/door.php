<?php

declare(strict_types=1);

namespace pvv\side;

use DateTimeImmutable;
use PDO;

class Door {
  private $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  /**
   * @return array{time: int, open: bool}[]
   */
  public function getAll(): array {
    $query = "SELECT time, open FROM door ORDER BY time DESC";
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    $doorEvents = [];
    foreach ($statement->fetchAll() as $row) {
      $doorEvents[] = [
        "time" => (int) $row["time"],
        "open" => (bool) $row["open"],
      ];
    }

    return $doorEvents;
  }

  /**
   * @return array{time: int, open: bool}[]
   */
  public function getEntriesAfter(DateTimeImmutable $startTime): array {
    $query =
      "SELECT time, open FROM door WHERE time > :startTime ORDER BY time DESC";
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(":startTime", $startTime, \PDO::PARAM_STR);
    $statement->execute();

    $doorEvents = [];
    foreach ($statement->fetchAll() as $row) {
      $doorEvents[] = [
        "time" => (int) $row["time"],
        "open" => (bool) $row["open"],
      ];
    }

    return $doorEvents;
  }

  /**
   * @return array{time: int, open: bool}
   */
  public function getCurrent(): array {
    $query = "SELECT time, open FROM door ORDER BY time DESC LIMIT 1";
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    $row = $statement->fetch();

    return [
      "time" => (int) $row["time"],
      "open" => (bool) $row["open"],
    ];
  }

  private function removeOld(): void {
    $firstValidTime = time() - 60 * 60 * 24 * 7; // One week before now
    $query = "DELETE FROM door WHERE time < :firstValid";
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(":firstValid", $firstValidTime, \PDO::PARAM_STR);
    $statement->execute();
  }

  public function createEvent(DateTimeImmutable $time, bool $open): void {
    $query = "INSERT INTO door(time, open) VALUES (:time, :open)";
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(":time", $time, \PDO::PARAM_STR);
    $statement->bindParam(":open", $open, \PDO::PARAM_STR);
    $statement->execute();

    $this->removeOld();
  }
}
