<?php
date_default_timezone_set('Europe/Oslo');
setlocale(\LC_ALL, 'nb_NO');
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../config.php';
$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$required_fields = [
  'title',
  'desc_no',
  'desc_en',
  'gitea',
  'issue',
  'wiki',
  'langs',
  'techs',
  'keywords',
  'license',
  'logo'
];

foreach ($required_fields as $field) {
  if (!isset($_POST[$field])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
  }
}

require_once __DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';
$as = new SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();

$id = $_POST['id'] ?? 0;
$do_delete = isset($_POST['delete']);
$do_join_or_leave = isset($_POST['join_or_leave']);

$title = $_POST['title'];
$desc_no = $_POST['desc_no'];
$desc_en = $_POST['desc_en'];
$gitea = $_POST['gitea'];
$issue = $_POST['issue'];
$wiki = $_POST['wiki'];
$langs = $_POST['langs'];
$techs = $_POST['techs'];
$keywords = $_POST['keywords'];
$license = $_POST['license'];
$logo = $_POST['logo'];

$name = $attrs['cn'][0];
$uname = $attrs['uid'][0];
$mail = $attrs['mail'][0];

if ($id == 0) { // Create new project
  $query = <<<END
    INSERT INTO
      project(
        title,
        description_no,
        description_en,
        gitea_link,
        issue_board_link,
        wiki_link,
        languages,
        technologies,
        keywords,
        license,
        logo_url
      )
    VALUES
      (
        :title,
        :desc_no,
        :desc_en,
        :gitea,
        :issue,
        :wiki,
        :langs,
        :techs,
        :keywords,
        :license,
        :logo
      )
  END;
  $statement = $pdo->prepare($query);

  $statement->bindParam(':title', $title, PDO::PARAM_STR);
  $statement->bindParam(':desc_no', $desc_no, PDO::PARAM_STR);
  $statement->bindParam(':desc_en', $desc_en, PDO::PARAM_STR);
  $statement->bindParam(':gitea', $gitea, PDO::PARAM_STR);
  $statement->bindParam(':issue', $issue, PDO::PARAM_STR);
  $statement->bindParam(':wiki', $wiki, PDO::PARAM_STR);
  $statement->bindParam(':langs', $langs, PDO::PARAM_STR);
  $statement->bindParam(':techs', $techs, PDO::PARAM_STR);
  $statement->bindParam(':keywords', $keywords, PDO::PARAM_STR);
  $statement->bindParam(':license', $license, PDO::PARAM_STR);
  $statement->bindParam(':logo', $logo, PDO::PARAM_STR);

  $statement->execute();
  $new_project_id = $pdo->lastInsertId();

  $ownerQuery = <<<END
    INSERT INTO
      project_maintainer (
        uname,
        project_id,
        name,
        email
      )
    VALUES
      (
        :username,
        :project_id,
        :user_real_name,
        :user_email
      )
  END;

  $statement = $pdo->prepare($ownerQuery);
  $statement->bindParam(':username', $uname, PDO::PARAM_STR);
  $statement->bindParam(':project_id', $new_project_id, PDO::PARAM_INT);
  $statement->bindParam(':user_real_name', $name, PDO::PARAM_STR);
  $statement->bindParam(':user_email', $mail, PDO::PARAM_STR);

  $statement->execute();
} else { // Update existing project
  $projectManager = new pvv\side\ProjectManager($pdo);
  $owner = $projectManager->getProjectOwner($id);
  $members = $projectManager->getProjectMembers($id);

  // if ($do_join_or_leave and $owner['uname'] != $uname) {
  if ($do_join_or_leave) {
    $is_member = false;
    foreach ($members as $member) {
      if ($member['uname'] == $uname && $member['owner'] == 0) {
        $is_member = true;
        break;
      }
    }
    if ($is_member) {// leave
      $query = 'DELETE FROM projectmembers WHERE projectid=:id AND uname=:uname and lead=FALSE and owner=FALSE;';
      $statement = $pdo->prepare($query);
      $statement->bindParam(':id', $id, PDO::PARAM_STR);
      $statement->bindParam(':uname', $uname, PDO::PARAM_STR);

      $statement->execute();
      echo 'leave';
    } else {// join
      $query = "INSERT INTO projectmembers (projectid, name, uname, mail, role, lead, owner) VALUES (:id, :name, :uname, :mail, 'Medlem', FALSE, FALSE)";
      $statement = $pdo->prepare($query);
      $statement->bindParam(':id', $id, PDO::PARAM_STR);
      $statement->bindParam(':name', $name, PDO::PARAM_STR);
      $statement->bindParam(':uname', $uname, PDO::PARAM_STR);
      $statement->bindParam(':mail', $mail, PDO::PARAM_STR);

      $statement->execute();
      echo 'join';
    }
    header('Location: ./info.php?id=' . $id);
    exit;
  }

  if ($uname != $owner['uname']) {
    header('Content-Type: text/plain', true, 403);
    echo "Illegal action, you're not the project owner for project with ID " . $id . "\r\n";
    exit;
  }

  if ($do_delete) {
    // this should be done as a transaction...
    $pdo->beginTransaction();

    $query = 'DELETE FROM projects WHERE id=:id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $query = 'DELETE FROM projectmembers WHERE projectid=:id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $pdo->commit();
  } else {
    $query = 'UPDATE projects SET name=:title, description=:desc WHERE id=:id';
    $statement = $pdo->prepare($query);

    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':desc', $desc, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();
  }
}

header('Location: ./mine.php');
?>

<a href="..">Om du ikke ble omdirigert tilbake klikk her</a>
