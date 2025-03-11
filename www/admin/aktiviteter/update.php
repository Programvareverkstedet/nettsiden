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

if (!$userManager->hasGroup($uname, 'aktiviteter')) {
  echo 'Her har du ikke lov\'t\'å\'værra!!!';
  exit;
}

if ((!isset($_POST['title']))
|| (!isset($_POST['desc']))
|| (!isset($_POST['organiser']))
|| (!isset($_POST['location']))
|| (!isset($_POST['start_mon']))
|| (!isset($_POST['start_day']))
|| (!isset($_POST['start_time']))
|| (!isset($_POST['lasts_hours']))
|| (!isset($_POST['lasts_minutes']))) {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
}

$id = 0;
if (isset($_POST['id'])) {
  $id = $_POST['id'];
}

$title = $_POST['title'];
$desc = $_POST['desc'];
// $start = $_POST['start'];
// $stop = $_POST['end'];
$organiser = $_POST['organiser'];
$location = $_POST['location'];

$date_part_start_mon     = $_POST['start_mon'];
$date_part_start_day     = $_POST['start_day'];
$date_part_start_time    = $_POST['start_time'];
$date_part_lasts_hours   = $_POST['lasts_hours'];
$date_part_lasts_minutes = $_POST['lasts_minutes'];

while (strlen($date_part_start_day) < 2) {
  $date_part_start_day = '0' . $date_part_start_day;
}

$start = ($date_part_start_mon . '-' . $date_part_start_day . ' ' . $date_part_start_time);
if (count(explode(':', $date_part_start_time)) == 2) {
  $start .= ':00';
}

$start_date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $start);
$stop_date = $start_date->add(new DateInterval('PT' . $date_part_lasts_hours . 'H' . $date_part_lasts_minutes . 'M'));
$start = $start_date->format('Y-m-d H:i:s');
$stop = $stop_date->format('Y-m-d H:i:s');

if ($start_date >= $stop_date) {
  echo 'Invalid dates. End date must come after the start date!';
  exit;
}


if ($id == 0) {
  $query = 'INSERT INTO events (name, start, stop, organiser, location, description) VALUES (:title, :start, :stop, :organiser, :loc, :desc)';
  $statement = $pdo->prepare($query);

  $statement->bindParam(':title', $title, PDO::PARAM_STR);
  $statement->bindParam(':desc', $desc, PDO::PARAM_STR);
  $statement->bindParam(':start', $start, PDO::PARAM_STR);
  $statement->bindParam(':stop', $stop, PDO::PARAM_STR);
  $statement->bindParam(':organiser', $organiser, PDO::PARAM_STR);
  $statement->bindParam(':loc', $location, PDO::PARAM_STR);
} else {
  $query = 'UPDATE events SET name=:title, start=:start, stop=:stop, organiser=:organiser, location=:loc, description=:desc WHERE id=:id';
  $statement = $pdo->prepare($query);

  $statement->bindParam(':title', $title, PDO::PARAM_STR);
  $statement->bindParam(':desc', $desc, PDO::PARAM_STR);
  $statement->bindParam(':start', $start, PDO::PARAM_STR);
  $statement->bindParam(':stop', $stop, PDO::PARAM_STR);
  $statement->bindParam(':organiser', $organiser, PDO::PARAM_STR);
  $statement->bindParam(':loc', $location, PDO::PARAM_STR);
  $statement->bindParam(':id', $id, PDO::PARAM_INT);
}

$statement->execute();

header('Location: .');
?>

<a href=".?page=1">Om du ikke ble automatisk omdirigert tilbake klikk her</a>
