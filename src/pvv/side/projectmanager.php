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
    $query = '
      SELECT
        id,
        title,
        description_en,
        description_no,
        gitea_link,
        issue_board_link,
        wiki_link,
        programming_languages,
        technologies,
        keywords,
        license,
        logo_url,
        is_hidden
      FROM project
      ORDER BY title ASC
    ';
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
        $dbProj['programming_languages'],
        $dbProj['technologies'],
        $dbProj['keywords'],
        $dbProj['license'],
        $dbProj['logo_url'],
        (bool) $dbProj['is_hidden']
      );
      $projects[] = $project;
    }

    return $projects;
  }

  // TODO: groupid
  public function getByID(int $id): ?Project {
    $query = '
      SELECT
        id,
        title,
        description_en,
        description_no,
        gitea_link,
        issue_board_link,
        wiki_link,
        programming_languages,
        technologies,
        keywords,
        license,
        logo_url,
        is_hidden
      FROM project
      WHERE id = :id
    ';
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
      $dbProj['programming_languages'],
      $dbProj['technologies'],
      $dbProj['keywords'],
      $dbProj['license'],
      $dbProj['logo_url'],
      (bool) $dbProj['is_hidden']
    );
  }


  // TODO: groupid
  /**
   * @return Project[]
   */
  public function getByMaintainer(string $uname): array {
    $query = '
      SELECT
        project.id,
        project.title
        project.description_en,
        project.description_no,
        project.gitea_link,
        project.issue_board_link,
        project.wiki_link,
        project.programming_languages,
        project.technologies,
        project.keywords,
        project.license,
        project.logo_url,
        project.is_hidden
      FROM project_maintainer
      JOIN project ON project.id = project_maintainer.project_id
      WHERE project_maintainer.uname = :uname
    ';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':uname', $uname, \PDO::PARAM_STR);
    $statement->execute();

    $result = array_map(
      function ($dbProj) {
        return new Project(
          $dbProj['id'],
          $dbProj['title'],
          $dbProj['description_en'],
          $dbProj['description_no'],
          $dbProj['gitea_link'],
          $dbProj['issue_board_link'],
          $dbProj['wiki_link'],
          $dbProj['programming_languages'],
          $dbProj['technologies'],
          $dbProj['keywords'],
          $dbProj['license'],
          $dbProj['logo_url'],
          (bool) $dbProj['is_hidden']
        );
      },
      $statement->fetchAll()
    );

    return $result;
  }

  /**
   * @return ProjectMaintainer[]
   */
  public function getProjectMaintainers(int $project_id): array {
    $query = '
      SELECT
        project_maintainer.uname,
        project_maintainer.name,
        project_maintainer.email,
        project_maintainer.is_organizer
      FROM project_maintainer
      WHERE project_maintainer.project_id = :id
    ';

    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $project_id, \PDO::PARAM_STR);
    $statement->execute();

    $result = array_map(
      function ($dbUsr) {
        return new ProjectMaintainer(
          $dbUsr['uname'],
          $dbUsr['name'],
          $dbUsr['email'],
          (bool)$dbUsr['is_organizer']
        );
      },
      $statement->fetchAll()
    );

    return $result;
  }

  /**
   * @return ProjectMaintainer[]
   */
  public function getProjectOrganizers(int $project_id): array {
    $query = '
      SELECT
        project_maintainer.uname,
        project_maintainer.name,
        project_maintainer.email,
        project_maintainer.is_organizer
      FROM project_maintainer
      WHERE
        project_maintainer.project_id = :id
        AND project_maintainer.is_organizer = True
    ';

    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':id', $project_id, \PDO::PARAM_STR);
    $statement->execute();

    $result = array_map(
      function ($dbUsr) {
        return new ProjectMaintainer(
          $dbUsr['uname'],
          $dbUsr['name'],
          $dbUsr['email'],
          (bool)$dbUsr['is_organizer']
        );
      },
      $statement->fetchAll()
    );

    return $result;
  }
}
