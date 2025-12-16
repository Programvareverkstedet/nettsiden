<?php

declare(strict_types=1);

namespace pvv\admin;

class UserManager {
  private \PDO $pdo;

  public array $usergroups = [
    'admin' => 1,
    'prosjekt' => 2,
    'aktiviteter' => 4,
  ];

  public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function setupUser(string $uname, int $groups = 0): void {
    $query = 'INSERT INTO users (uname, groups) VALUES (:uname, :groups)';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':uname', $uname, \PDO::PARAM_STR);
    $statement->bindParam(':groups', $groups, \PDO::PARAM_INT);
    $statement->execute();
  }

  public function updateFlags(string $uname, int $flags): void {
    $query = 'UPDATE users set groups=:groups WHERE uname=:uname';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':groups', $flags, \PDO::PARAM_INT);
    $statement->bindParam(':uname', $uname, \PDO::PARAM_STR);
  }

  public function addGroup(string $uname, int $group): void {
    $userFlags = $this->getUsergroups($uname);

    if ($userFlags) {
      $newFlags = ($group | $userFlags);
      $this->updateFlags($uname, $newFlags);
    }
  }

  public function removeGroup(string $uname, int $group): void {
    $userFlags = $this->getUsergroups($uname);

    if ($userFlags) {
      $newFlags = ($userFlags & (~ $group));
      $this->updateFlags($uname, $newFlags);
    }
  }

  public function setGroups(string $uname, int $groups): void {
    $query = 'SELECT * FROM users WHERE uname=:uname LIMIT 1';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':uname', $uname, \PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch();

    if ($row) {
      $query = 'UPDATE users set groups=:groups WHERE uname=:uname';
      $statement = $this->pdo->prepare($query);
      $statement->bindParam(':groups', $groups, \PDO::PARAM_INT);
      $statement->bindParam(':uname', $uname, \PDO::PARAM_STR);
      $statement->execute();
    } else {
      $this->setupUser($uname, $groups);
    }
  }

  public function hasGroup(string $uname, string $groupName): bool {
    $userFlags = $this->getUsergroups($uname);

    return (bool) ($userFlags & $this->usergroups[$groupName]);
  }

  // for convenience
  public function isAdmin(string $uname): bool {
    return $this->hasGroup($uname, 'admin');
  }

  public function getFlagfromNames(array $names): int {
    $resultFlag = 0;

    foreach ($this->usergroups as $name => $flag) {
      if (\in_array($name, $names, true)) {
        $resultFlag = ($resultFlag | $flag);
      }
    }

    return $resultFlag;
  }

  public function getUsergroups(string $uname): int {
    $query = 'SELECT groups FROM users WHERE uname=:uname LIMIT 1';
    $statement = $this->pdo->prepare($query);
    $statement->bindParam(':uname', $uname, \PDO::PARAM_STR);
    $statement->execute();

    $row = $statement->fetch();
    if ($row === false) {
      return 0;
    }

    return $row[0];
  }

  /**
   * @return string[]
   */
  public function getUsergroupNames($uname): array {
    $usersGroups = [];

    $userFlags = $this->getUsergroups($uname);

    foreach ($this->usergroups as $name => $flag) {
      if ($userFlags & $flag) {
        $usersGroups[] = $name;
      }
    }

    return $usersGroups;
  }

  /**
   * @return array<int,array{name:string,groups:string[]}>
   */
  public function getAllUserData(): array {
    $query = 'SELECT uname FROM users ORDER BY uname ASC';
    $statement = $this->pdo->prepare($query);
    $statement->execute();

    $users = [];
    foreach ($statement->fetchAll() as $userData) {
      $uname = $userData['uname'];
      $users[] = [
        'name' => $uname,
        'groups' => $this->getUsergroupNames($uname),
      ];
    }

    return $users;
  }
}
