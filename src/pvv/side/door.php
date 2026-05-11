<?php

declare(strict_types=1);

namespace pvv\side;

class DoorStatus {
  private \DateTimeImmutable $time;
  private bool $open;

  public function __construct(\DateTimeImmutable $time, bool $open) {
    $this->time = $time;
    $this->open = $open;
  }

  public function getTime(): \DateTimeImmutable {
    return $this->time;
  }

  public function getTimeStamp(): int {
    return $this->time->getTimestamp();
  }

  public function isOpen(): bool {
    return $this->open;
  }
}

class Door {
  private $pdo;

  public const DAYS_OF_DOOR_HISTORY = 7;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  /**
   * @return DoorStatus[]
   */
  public function getAll(): array {
    $query = '
      SELECT
        time,
        open
      FROM door
      ORDER BY time DESC
    ';
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    $result = array_map(
      static fn ($row) => new DoorStatus(
        new \DateTimeImmutable()->setTimestamp((int) $row['time']),
        (bool) $row['open'],
      ),
      $statement->fetchAll(),
    );

    return $result;
  }

  /**
   * @return DoorStatus[]
   */
  public function getEntriesAfter(\DateTimeImmutable $startTime): array {
    $query = '
      SELECT
        time,
        open
      FROM door
      WHERE time > :startTime
      ORDER BY time DESC
    ';
    $statement = $this->pdo->prepare($query);
    $statement->bindValue(':startTime', $startTime->getTimestamp(), \PDO::PARAM_INT);
    $statement->execute();

    $result = array_map(
      static fn ($row) => new DoorStatus(
        new \DateTimeImmutable()->setTimestamp((int) $row['time']),
        (bool) $row['open'],
      ),
      $statement->fetchAll(),
    );

    return $result;
  }

  public function getCurrent(): ?DoorStatus {
    $query = '
      SELECT
        time,
        open
      FROM door
      ORDER BY time DESC
      LIMIT 1
    ';
    $statement = $this->pdo->prepare($query);
    $statement->execute();
    $row = $statement->fetch();

    if (!$row) {
      return null;
    }

    return new DoorStatus(
      new \DateTimeImmutable()->setTimestamp((int) $row['time']),
      (bool) $row['open'],
    );
  }

  private function removeOld(): void {
    $firstValidTime = time() - 60 * 60 * 24 * self::DAYS_OF_DOOR_HISTORY;
    $query = 'DELETE FROM door WHERE time < :firstValid';
    $statement = $this->pdo->prepare($query);
    $statement->bindValue(':firstValid', $firstValidTime, \PDO::PARAM_INT);
    $statement->execute();
  }

  public function createEvent(\DateTimeImmutable $time, bool $open): void {
    $query = 'INSERT INTO door(time, open) VALUES (:time, :open)';
    $statement = $this->pdo->prepare($query);
    $statement->bindValue(':time', $time->getTimestamp(), \PDO::PARAM_INT);
    $statement->bindValue(':open', $open, \PDO::PARAM_BOOL);
    $statement->execute();

    $this->removeOld();
  }
}
