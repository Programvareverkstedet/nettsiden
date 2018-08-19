<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
use \pvv\side\Agenda;

$eventID = 0;
if(isset($_GET['id'])){
	$eventID = $_GET['id'];
}else{
	echo 'No event ID provided';
	exit();
}

$dbActivity = new \pvv\side\DBActivity($pdo);
$event = $dbActivity->getEventByID($eventID);
if(!$event){
	echo 'Failed to retrieve event info';
	exit();
}
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<meta name="theme-color" content="#024" />
<title>Aktivitetsverkstedet</title>

<header>Aktivitets&shy;verk&shy;stedet</header>

<body>
	<main>
		<article>
			<h2>
				<?php if (\pvv\side\Agenda::isToday($event->getStart())) { ?><strong><?php } ?>
				<em><?= $event->getRelativeDate() ?></em>
				<?php if (\pvv\side\Agenda::isToday($event->getStart())) { ?></strong><?php } ?>
				
				<?= $event->getName() ?>
			</h2>
			<ul class="subtext">
				<li>Tid: <strong><?= Agenda::getFormattedDate($event->getStart()) ?></strong></li>
				<li>Sted: <strong><?= $event->getLocation() ?></strong></li>
				<li>Arrangør: <strong><?= $event->getOrganiser() ?></strong></li>
			</ul>

			<?php $description = $event->getDescription(); ?>
			<?php
			$Parsedown = new \Parsedown();
			echo $Parsedown->text(implode("\n", $description));
			?>
		</article>
	</main>

	<nav>
		<?php echo navbar(1, 'aktiviteter'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>
</body>
