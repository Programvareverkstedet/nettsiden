<?php

declare(strict_types=1);

namespace pvv\side;

class ProjectManager {
  private $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  // TODO: groupid

  /**
   * @return Project[]
   */
  public function getAll(): array {
    $query = 'SELECT * FROM project ORDER BY id ASC';
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    $projects = [];
    foreach ($statement->fetchAll() as $dbProj) {
      $project = new Project(
        $dbProj['id'],
        $dbProj['title'],
        $dbProj['description_en'],
        $dbProj['description_no'],
        $dbProj['gitea_link'],
        $dbProj['issue_board_link'],
        $dbProj['wiki_link'],
        $dbProj['languages'],
        $dbProj['technologies'],
        $dbProj['keywords'],
        $dbProj['license'],
        $dbProj['logo_url']
      );
      $projects[] = $project;
    }

    return $projects;
  }

  // TODO: groupid
  public function getByID(int $id): ?Project {
    $query = 'SELECT * FROM project WHERE id=:id LIMIT 1';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $id, \PDO::PARAM_INT);
    $statement->execute();

    $dbProj = $statement->fetch();
    if (!$dbProj) {
      return null;
    }

    return new Project(
      $dbProj['id'],
      $dbProj['title'],
      $dbProj['description_en'],
      $dbProj['description_no'],
      $dbProj['gitea_link'],
      $dbProj['issue_board_link'],
      $dbProj['wiki_link'],
      $dbProj['languages'],
      $dbProj['technologies'],
      $dbProj['keywords'],
      $dbProj['license'],
      $dbProj['logo_url']
    );
  }


  // TODO: groupid
  /**
   * @return Project[]
   */
  public function getByOwner(string $uname): array {
    $query = '
      SELECT project.id FROM project
      JOIN project_maintainer ON project.id = project_maintainer.project_id
      WHERE project_maintainer.uname = :uname
        AND project_maintainer.is_owner = TRUE
    ';

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
          $dbProj['title'],
          $dbProj['description_en'],
          $dbProj['description_no'],
          $dbProj['gitea_link'],
          $dbProj['issue_board_link'],
          $dbProj['wiki_link'],
          $dbProj['languages'],
          $dbProj['technologies'],
          $dbProj['keywords'],
          $dbProj['license'],
          $dbProj['logo_url']
        );
        $projects[] = $project;
      }
    }

    return $projects;
  }

  /**
   * @return {uname:string,name:string,link:string,email:string,is_owner:bool}[]
   */
  public function getProjectMembers(int $project_id): array {
    $query = '
      SELECT
        project_maintainer.uname,
        project_maintainer.name,
        project_maintainer.email,
        project_maintainer.is_owner
      FROM project_maintainer
      WHERE project_maintainer.project_id = :id
    ';

    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $project_id, \PDO::PARAM_STR);
    $statement->execute();

    $maintainers = [];
    foreach ($statement->fetchAll() as $dbUsr) {
      $maintainers[] = [
        'uname' => $dbUsr['uname'],
        'name' => $dbUsr['name'],
        'email' => $dbUsr['email'],
        'is_owner' => (bool)$dbUsr['is_owner'],
      ];
    }

    return $maintainers;
  }

  /**
   * @return array{name:string,uname:string,email:string,is_owner:bool}|null
   */
  public function getProjectOwner(int $project_id): ?array {
    $query = '
      SELECT
        project_maintainer.name,
        project_maintainer.uname,
        project_maintainer.email,
        project_maintainer.is_owner
      FROM project_maintainer
      WHERE project_maintainer.project_id = :id
        AND project_maintainer.is_owner = TRUE
      LIMIT 1
    ';

    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $project_id, \PDO::PARAM_STR);
    $statement->execute();

    $owner = $statement->fetch();
    if (!$owner) {
      return null;
    }

    return [
      'name' => $owner['name'],
      'uname' => $owner['uname'],
      'email' => $owner['email'],
      'is_owner' => (bool)$owner['is_owner'],
    ];
  }
}
