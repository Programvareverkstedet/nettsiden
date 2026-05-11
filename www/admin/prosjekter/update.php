<?php
date_default_timezone_set('Europe/Oslo');
setlocale(\LC_ALL, 'nb_NO');
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../config.php';
$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new pvv\admin\UserManager($pdo);

require_once __DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';
$as = new SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if (!$userManager->hasGroup($uname, 'prosjekt')) {
  echo 'Her har du ikke lov\'t\'å\'værra!!!';
  exit;
}

if (!isset($_POST['title']) || !isset($_POST['desc']) || !isset($_POST['organisername']) || !isset($_POST['organiser'])) {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
}

$id = 0;
if (isset($_POST['id'])) {
  $id = $_POST['id'];
}

$title = $_POST['title'];
$desc = $_POST['desc'];
$name = $_POST['organisername'];
$uname = $_POST['organiser'];
$mail = $_POST['organiseremail'];
$active = ($_POST['active'] ?? false);


if ($id == 0) {
  $query = '
    INSERT INTO
      projects(name, description, active)
    VALUES
      (:title, :desc, :active)
  ';
  $statement = $pdo->prepare($query);

  $statement->bindValue(':title', $title, PDO::PARAM_STR);
  $statement->bindValue(':desc', $desc, PDO::PARAM_STR);
  $statement->bindValue(':active', $active, PDO::PARAM_BOOL);

  $statement->execute();

  $ownerQuery = '
    INSERT INTO
      projectmembers(projectid, name, uname, mail, role, lead, owner)
    VALUES
      (last_insert_rowid(), :owner, :owneruname, :owneremail, \'Prosjektleder\', 1, 1)
  ';
  $statement = $pdo->prepare($ownerQuery);
  $statement->bindValue(':owner', $name, PDO::PARAM_STR);
  $statement->bindValue(':owneruname', $uname, PDO::PARAM_STR);
  $statement->bindValue(':owneremail', $mail, PDO::PARAM_STR);

  $statement->execute();
} else {
  $query = '
    UPDATE
      projects
    SET
      name = :title,
      description = :desc,
      active = :active
    WHERE
      id = :id
  ';
  $statement = $pdo->prepare($query);

  $statement->bindValue(':title', $title, PDO::PARAM_STR);
  $statement->bindValue(':desc', $desc, PDO::PARAM_STR);
  $statement->bindValue(':active', $active, PDO::PARAM_BOOL);
  $statement->bindValue(':id', $id, PDO::PARAM_INT);

  $statement->execute();

  $query = '
    UPDATE
      projectmembers
    SET
      name = :name,
      uname = :uname,
      mail = :mail
  ';
  $statement = $pdo->prepare($query);

  $statement->bindValue(':name', $name, PDO::PARAM_STR);
  $statement->bindValue(':uname', $uname, PDO::PARAM_STR);
  $statement->bindValue(':mail', $mail, PDO::PARAM_STR);

  $statement->execute();
}

header('Location: .');
?>

<a href=".?page=1">Om du ikke ble automatisk omdirigert tilbake klikk her</a>
