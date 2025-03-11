<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(\LC_ALL, 'nb_NO');
error_reporting(\E_ALL);
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

if (!$userManager->isAdmin($uname)) {
  echo 'Her har du ikke lov\'t\'å\'værra!!!';
  exit;
}


if (isset($_POST['newuser'])) {
  $newUser = $_POST['newuser'];
  unset($_POST['newuser']);
}

// $updatingUsers = explode('_', $_POST['users']);
$updatingUsers = [];
foreach ($_POST as $key => $value) {
  if ($key === 'user_to_update') {
    $updatingUsers[] = $value;
  }
}
unset($_POST['user_to_update']);

// 2d array of usernames and their corresponding group flags
$userFlags = [];
if ($newUser) {
  $userFlags[$newUser] = 0;
}

foreach ($_POST as $namegroup => $info) {
  $data = explode('_', $namegroup);
  $group = array_pop($data);
  $uname = implode('_', $data);
  if ($uname == 'newuser') {
    if (!$newUser) {
      continue;
    }

    $uname = $newUser;
  }

  if (!isset($userFlags[$uname])) {
    $userFlags[$uname] = 0;
  }

  $userFlags[$uname] = ($userFlags[$uname] | $userManager->usergroups[$group]);
}

foreach ($updatingUsers as $uname) {
  if (!array_key_exists($uname, $userFlags)) {
    $userFlags[$uname] = 0;
  }
}

foreach ($userFlags as $uname => $flag) {
  $userManager->setGroups($uname, $flag);
}

header('Location: .');
?>

<a href=".">Om du ikke ble automatisk omdirigert tilbake klikk her</a>
