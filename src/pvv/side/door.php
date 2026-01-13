<?php

declare(strict_types=1);

namespace pvv\side;

use DateTimeImmutable;

class Door {
  private $pdo;

  const DAYS_OF_DOOR_HISTORY = 7;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  /**
   * @return array{time: DateTimeImmutable, open: bool}[]
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

    $doorEvents = [];
    foreach ($statement->fetchAll() as $row) {
      $doorEvents[] = [
        'time' => (new DateTimeImmutable)->setTimestamp((int) $row['time']),
        'open' => (bool) $row['open'],
      ];
    }

    return $doorEvents;
  }

  /**
   * @return array{time: DateTimeImmutable, open: bool}[]
   */
  public function getEntriesAfter(\DateTimeImmutable $startTime): array {
    $timestamp = $startTime->getTimestamp();

    $query = '
      SELECT
        time,
        open
      FROM door
      WHERE time > :startTime
      ORDER BY time DESC
    ';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':startTime', $timestamp, \PDO::PARAM_INT);
    $statement->execute();

    $doorEvents = [];
    foreach ($statement->fetchAll() as $row) {
      $doorEvents[] = [
        'time' => (new DateTimeImmutable)->setTimestamp((int) $row['time']),
        'open' => (bool) $row['open'],
      ];
    }

    return $doorEvents;
  }

  /**
   * @return ?array{time: DateTimeImmutable, open: bool}
   */
  public function getCurrent(): ?array {
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

    return [
      'time' => (new DateTimeImmutable)->setTimestamp((int) $row['time']),
      'open' => (bool) $row['open'],
    ];
  }

  private function removeOld(): void {
    $firstValidTime = time() - 60 * 60 * 24 * self::DAYS_OF_DOOR_HISTORY;
    $query = 'DELETE FROM door WHERE time < :firstValid';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':firstValid', $firstValidTime, \PDO::PARAM_INT);
    $statement->execute();
  }

  public function createEvent(\DateTimeImmutable $time, bool $open): void {
    $query = 'INSERT INTO door(time, open) VALUES (:time, :open)';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':time', $time->getTimestamp(), \PDO::PARAM_INT);
    $statement->bindParam(':open', $open, \PDO::PARAM_BOOL);
    $statement->execute();

    $this->removeOld();
  }
}
