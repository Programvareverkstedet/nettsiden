<?php

declare(strict_types=1);

namespace pvv\side;

class DBActivity implements Activity {
  private $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  /**
   * @return SimpleEvent[]
   */
  public function getAllEvents(): array {
    $query = 'SELECT * FROM events ORDER BY id DESC';
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    $events = [];
    foreach ($statement->fetchAll() as $dbEvent) {
      $event = new SimpleEvent(
        $dbEvent['id'],
        $dbEvent['name'],
        \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dbEvent['start']),
        \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dbEvent['stop']),
        $dbEvent['organiser'],
        $dbEvent['location'],
        $dbEvent['description'],
      );
      $events[] = $event;
    }

    return $events;
  }

  public function getEventByID(int $id): SimpleEvent {
    $query = 'SELECT * FROM events WHERE id=:id LIMIT 1';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $id, \PDO::PARAM_INT);
    $statement->execute();

    $dbEvent = $statement->fetch();

    return new SimpleEvent(
      $dbEvent['id'],
      $dbEvent['name'],
      \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dbEvent['start']),
      \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dbEvent['stop']),
      $dbEvent['organiser'],
      $dbEvent['location'],
      $dbEvent['description'],
    );
  }

  public function getNextEventFrom(\DateTimeImmutable $date): ?Event {
    $query = '
      SELECT
        id,
        name,
        start,
        stop,
        organiser,
        location,
        description
      FROM events
      WHERE
        start > :date
      ORDER BY start ASC
      LIMIT 1
    ';

    return $this->retrieve($date, $query);
  }

  public function getPreviousEventFrom(\DateTimeImmutable $date): ?Event {
    $query = '
      SELECT
        id,
        name,
        start,
        stop,
        organiser,
        location,
        description
      FROM events
      WHERE
        start < :date
      ORDER BY start DESC
      LIMIT 1
    ';

    return $this->retrieve($date, $query);
  }

  private function retrieve(
    \DateTimeImmutable $date,
    string $query,
  ): ?SimpleEvent {
    $stmt = $this->pdo->prepare($query);
    $stmt->execute(['date' => $date->format('Y-m-d H:i:s')]);
    if ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      return new SimpleEvent(
        $result['id'],
        $result['name'],
        \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['start']),
        \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['stop']),
        $result['organiser'],
        $result['location'],
        $result['description'],
      );
    }

    return null;

  }
}
