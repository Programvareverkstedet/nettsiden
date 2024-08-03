<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../../inc/navbar.php';
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../config.php';

$pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];
$name = $attrs['cn'][0];

if(!$userManager->hasGroup($uname, 'aktiviteter')){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}

$customActivity = new \pvv\side\DBActivity($pdo);

$new = 0;
if(isset($_GET['new'])){
	$new = $_GET['new'];
}

$eventID = 0;
if(isset($_GET['id'])){
	$eventID = $_GET['id'];
}else if($new == 0){
	echo "\nID not set";
	exit();
}

$today = new DateTimeImmutable;
$today = $today->setTime(18, 15);
$defaultStart = $today->format("Y-m-d H:15:00");
$inTwoHours = $today->add(new DateInterval('PT1H45M'));
$defaultEnd = $inTwoHours->format("Y-m-d H:00:00");

$event;
if($new == 0){
	$event = $customActivity->getEventByID($eventID);
}
else {
	$event = new \pvv\side\SimpleEvent(
	   0,
	   '',
	   $today,
	   $inTwoHours,
	   '',
	   '',
	   ''
   );
}


?>
<!DOCTYPE html>
<html lang="no" locale="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/nav.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">
<meta name="theme-color" content="#024" />
<title>Adminverkstedet</title>

<header>Admin&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(3, 'admin'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Aktivietsadministrasjon</h2>
		<hr class="ruler">

		<h2><?= ($new == 1 ? "Ny hendelse" : "Rediger hendelse"); ?></h2>

		<form action="update.php", method="post" class="gridsplit fullwidth_inputs">
			<div class="gridl">
				<p class="subtitle">Tittel</p>
				<input type="text" name="title" value="<?= $event->getName() ?>" class="boxinput" required placeholder="En kul hendelse"><br>
				
				<div class="gridsplit5050">
					<div class="gridl">
						<p class="subtitle">Arrangør</p>
						<input type="text" name="organiser" value="<?= $event->getOrganiser() ?>" class="boxinput" required placeholder="<?= $name ?>"><br>
					</div>
					<div class="gridr noborder">
						<p class="subtitle">Sted</p>
						<input type="text" name="location" value="<?= $event->getLocation() ?>" class="boxinput" required placeholder="Terminalrommet"><br>
					</div>
				</div>

				<p class="subtitle">Beskrivelse (<i>markdown</i>)</p>
				<textarea name="desc" rows="8" class="boxinput" placeholder="Beskrivelse" required><?= implode("\n", $event->getDescription()); ?></textarea>
				
				
			</div>

			<div class="gridr" style="line-height: 1.3em;">
				<h4>Starttid</h4><br>
				<i>Måned:</i><br>
				<input name="start_mon" type="month" class="boxinput" required value="<?= $event->getStart()->format('Y-m') ?>"><br>
				<i>Dag:</i><br>
				<input name="start_day" type="number" min="1" max="31" required class="boxinput" value="<?= $event->getStart()->format('d') ?>"><br>
				<i>Klokkeslett:</i><br>
				<input name="start_time" type="time" class="boxinput" required value="<?= $event->getStart()->format('H:i:s') ?>"><br>
				<br>
				<h4>Varighet</h4><br>
				<?php $diff = $event->getStart()->diff($event->getStop()); ?>
				<i>Timer:</i><br>
				<input name="lasts_hours" type="number" min="0" class="boxinput" required value="<?= $diff->h ?>"><br>
				<i>Minutter:</i><br>
				<input name="lasts_minutes" type="number" min="0" max="59" class="boxinput" required value="<?= $diff->i ?>"><br>
				
			</div>

			<input type="hidden" name="id" value="<?= $event->getID() ?>" />

			<div class="allgrids" style="margin-top: 2em;">
				<hr class="ruler">
				<input type="submit" class="btn" value="Lagre"></a>
			</div>
		</form>

		

		<p>
	</main>
</body>
