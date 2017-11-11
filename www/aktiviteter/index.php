<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require_once __DIR__ . '/../../inc/navbar.php';
require_once __DIR__ . '/../../src/_autoload.php';
require_once __DIR__ . '/../../sql_config.php';

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
use \pvv\side\Agenda;
$agenda = new \pvv\side\Agenda([
		new \pvv\side\social\NerdepitsaActivity,
		new \pvv\side\social\AnimekveldActivity,
		new \pvv\side\DBActivity($pdo),
	]);

$year = (isset($_GET['year']))
	? $_GET['year']
	: date("Y");
$month = (isset($_GET['month']))
	? $_GET['month']
	: date("m");
$day = (isset($_GET['day']))
	? $_GET['day']
	: -1;

?>
<!DOCTYPE html>
<html lang="no">
<title>Aktivitetsverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">

<header>Aktivitets&shy;verk&shy;stedet</header>

<main>

<?php
$events = ($day==-1)
	? $agenda->getNextOfEach(new \DateTimeImmutable)
	: $agenda->getEventsBetween(
		new DateTimeImmutable("$year-$month-$day 00:00:00"),
		new DateTimeImmutable("$year-$month-$day 23:59:59"));

$limit = 0;
foreach($events as $event) {
?>
<article>
	<h2>
		<?php if ($event->getImageURL()) { ?>
		<img src="<?= $event->getImageURL() ?>">
		<?php } ?>
		<?php if (\pvv\side\Agenda::isToday($event->getStart())) { ?><strong><?php } ?>
		<em><?= $event->getRelativeDate() ?></em>
		<?php if (\pvv\side\Agenda::isToday($event->getStart())) { ?></strong><?php } ?>
		<?php if ($event->getURL()) { ?>
		<a href="<?= $event->getURL() ?>"><?= $event->getName() ?></a>
		<?php } else { ?>
		<?= $event->getName() ?>
		<?php } ?>
	</h2>
	<ul class="subtext">
		<li>Tid: <strong><?= Agenda::getFormattedDate($event->getStart()) ?></strong>
		<li>Sted: <strong><?= $event->getLocation() ?></strong>
		<li>Arrangør: <strong><?= $event->getOrganiser() ?></strong>
	</ul>

	<?php $description = $event->getDescription(); ?>
	<?php if ($limit) array_splice($description, $limit); ?>
	<?= implode($description, "</p>\n<p>") ?>
</article>

<?php if (!$limit || $limit > 4) {$limit = 4;} else $limit = 2; ?>
<?php } ?>

</main>

<nav>
	<?= navbar(1, 'aktiviteter'); ?>
	<?= loginbar(); ?>
</nav>
