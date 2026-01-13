<?php

declare(strict_types=1);

namespace pvv\side;

class MOTD {
  private $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function setMOTD(string $title, string $content): void {
    if (\is_array($content)) {
      $content = implode('_', $content);
    }
    $query = 'INSERT INTO motd(title, content) VALUES (:title, :content);';
    $statement = $this->pdo->prepare($query);

    $statement->bindParam(':title', $title, \PDO::PARAM_STR);
    $statement->bindParam(':content', $content, \PDO::PARAM_STR);

    $statement->execute();
  }

  /**
   * @return array{title: string, content: string[]}
   */
  public function getMOTD(): array {
    $query = '
      SELECT
        title,
        content
      FROM motd
      ORDER BY id DESC
      LIMIT 1
    ';
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    $data = $statement->fetch();

    return ['title' => $data[0], 'content' => explode("\n", $data[1])];
  }

  /**
   * @return array{title: string, content: string[]}
   */
  public function getMOTD_history(int $limit = 5): array {
    $query = '
      SELECT
        title,
        content
      FROM motd
      ORDER BY id DESC
      LIMIT :limit
    ';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':limit', $limit, \PDO::PARAM_STR);
    $statement->execute();

    $data = $statement->fetch();

    return ['title' => $data[0], 'content' => explode("\n", $data[1])];
  }
}
