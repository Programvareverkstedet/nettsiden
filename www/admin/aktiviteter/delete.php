<?php
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

if (!$userManager->hasGroup($uname, 'aktiviteter')) {
  echo 'Her har du ikke lov\'t\'å\'værra!!!';
  exit;
}

$eventID = $_GET['id'];

$query = 'DELETE FROM events WHERE id=\'' . $eventID . '\'';
$statement = $pdo->prepare($query);
$statement->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

<a href=".?page=1">Om du ikke ble omdirigert tilbake klikk her</a>