<?php

declare(strict_types=1);

namespace pvv\side;

class MOTDItem {
  private string $title;
  /** @var string[] */
  private array $content;

  /**
   * @param string[] $content
   */
  public function __construct(string $title, array $content) {
    $this->title = $title;
    $this->content = $content;
  }

  public function getTitle(): string {
    return $this->title;
  }

  /**
   * @return string[]
   */
  public function getContent(): array {
    return $this->content;
  }

  public function getContentAsString(): string {
    return implode("\n", $this->content);
  }
}

class MOTD {
  private $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function setMOTD(string $title, string $content): void {
    if (\is_array($content)) {
      $content = implode('_', $content);
    }
    $query = 'INSERT INTO motd(title, content) VALUES (:title, :content)';
    $statement = $this->pdo->prepare($query);

    $statement->bindParam(':title', $title, \PDO::PARAM_STR);
    $statement->bindParam(':content', $content, \PDO::PARAM_STR);

    $statement->execute();
  }

  public function getMOTD(): MOTDItem {
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

    $result = new MOTDItem(
      $data['title'],
      explode("\n", $data['content']),
    );

    return $result;
  }

  /**
   * @return MOTDItem[]
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

    $result = array_map(
      function ($item) {
        return new MOTDItem(
          $item['title'],
          explode("\n", $item['content']),
        );
      },
      $statement->fetchAll(),
    );

    return $result;
  }
}
