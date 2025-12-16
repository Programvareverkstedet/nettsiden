<?php

declare(strict_types=1);

namespace pvv\side;

class ProjectManager {
  private $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  /**
   * @return Project[]
   */
  public function getAll(): array {
    $query = 'SELECT * FROM projects ORDER BY id ASC';
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    $projects = [];
    foreach ($statement->fetchAll() as $dbProj) {
      $project = new Project(
        $dbProj['id'],
        $dbProj['name'],
        $dbProj['description'],
        $dbProj['active'],
      );
      $projects[] = $project;
    }

    return $projects;
  }

  public function getByID(int $id): ?Project {
    $query = 'SELECT * FROM projects WHERE id=:id LIMIT 1';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $id, \PDO::PARAM_INT);
    $statement->execute();

    $dbProj = $statement->fetch();
    if (!$dbProj) {
      return null;
    }

    return new Project(
      $dbProj['id'],
      $dbProj['name'],
      $dbProj['description'],
      $dbProj['active'],
    );
  }

  /**
   * @return Project[]
   */
  public function getByOwner(string $uname): array {
    $query = 'SELECT projectid FROM projectmembers WHERE uname=:uname';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':uname', $uname, \PDO::PARAM_STR);
    $statement->execute();

    $projectIDs = $statement->fetchAll();
    $projects = [];
    foreach ($projectIDs as $id) {
      $id = $id['projectid'];

      $query = 'SELECT * FROM projects WHERE id=:id';
      $statement = $this->pdo->prepare($query);
      $statement->bindParam(':id', $id, \PDO::PARAM_INT);
      $statement->execute();

      foreach ($statement->fetchAll() as $dbProj) {
        $project = new Project(
          $dbProj['id'],
          $dbProj['name'],
          $dbProj['description'],
          $dbProj['active'],
        );
        $projects[] = $project;
      }
    }

    return $projects;
  }

  /**
   * @return array<int,array>
   */
  public function getProjectMembers(int $id): array {
    $query = 'SELECT * FROM projectmembers WHERE projectid=:id';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $id, \PDO::PARAM_STR);
    $statement->execute();

    $members = [];
    foreach ($statement->fetchAll() as $dbUsr) {
      $members[] = [
        'name' => $dbUsr['name'],
        'uname' => $dbUsr['uname'],
        'mail' => $dbUsr['mail'],
        'role' => $dbUsr['role'],
        'lead' => $dbUsr['lead'],
        'owner' => $dbUsr['owner'],
      ];
    }

    return $members;
  }

  /**
   * @return array<string,mixed>
   */
  public function getProjectOwner(int $id): array {
    $query = 'SELECT * FROM projectmembers WHERE (projectid=:id AND owner=1)';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $id, \PDO::PARAM_STR);
    $statement->execute();

    $dbOwner = $statement->fetch();

    return [
      'name' => $dbOwner['name'],
      'uname' => $dbOwner['uname'],
      'mail' => $dbOwner['mail'],
      'role' => $dbOwner['role'],
      'lead' => $dbOwner['lead'],
      'owner' => $dbOwner['owner'],
    ];
  }
}
