<?php

declare(strict_types=1);

namespace pvv\side;

class ProjectManager {
  private $pdo;

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function getAll() {
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

  public function getByID($id) {
    $query = 'SELECT * FROM project WHERE id=:id LIMIT 1';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $id, \PDO::PARAM_INT);
    $statement->execute();

    $dbProj = $statement->fetch();
    if (!$dbProj) {
      return false;
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

  public function getByOwner($uname) {
    $query = '
      SELECT projectid FROM project
      JOIN project__project_maintainer ON project.id = project__project_maintainer.project_id
      JOIN project_maintainer ON project__project_maintainer.uname = project_maintainer.uname
      WHERE project_maintainer.uname = :uname
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

  public function getProjectMaintainers($id) {
    $query = '
      SELECT id FROM project
      JOIN project__project_maintainer ON project.id = project__project_maintainer.project_id
      JOIN project_maintainer ON project__project_maintainer.uname = project_maintainer.uname
      WHERE project.id = :id
    ';
    
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $id, \PDO::PARAM_STR);
    $statement->execute();

    $maintainers = [];
    foreach ($statement->fetchAll() as $dbUsr) {
      $maintainers[] = [
        'name' => $dbUsr['name'],
        'uname' => $dbUsr['uname'],
        'link' => $dbOwner['link'],
        'mail' => $dbUsr['mail'],
      ];
    }

    return maintainers;
  }
}
