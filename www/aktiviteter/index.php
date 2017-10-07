<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

use \pvv\side\Agenda;
$agenda = new \pvv\side\Agenda([
		new \pvv\side\social\NerdepitsaActivity,
		new \pvv\side\social\AnimekveldActivity,
		new \pvv\side\social\BrettspillActivity,
		new \pvv\side\DBActivity($pdo),
	]);
?><!DOCTYPE html>
<html lang="no">
<title>Aktivitetverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">

<header>Aktivitet&shy;verk&shy;stedet</header>

<main>

<?php $limit = 0; ?>
<?php foreach($agenda->getNextOfEach(new \DateTimeImmutable) as $event) { ?>

<article>
	<h2>
		<?php if ($event->getImageURL()) { ?>
		<img src="<?= $event->getImageURL() ?>">
		<?php } ?>
		<?php if (\pvv\side\Agenda::isToday($event->getStart())) { ?><strong><?php } ?>
		<em><?= $event->getRelativeDate() ?></em>
		<?php if (\pvv\side\Agenda::isToday($event->getStart())) { ?></strong><?php } ?>
		<a href="<?= $event->getURL() ?>"><?= $event->getName() ?></a>
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

<nav><ul>
	<li><a href="../">hjem</a></li>
	<!--<li><a href="../prosjekt/">prosjekter</a></li>-->
	<li><a href="../kalender/">kalender</a></li>
	<li class="active"><a href="../aktiviteter/">aktiviteter</a></li>
	<li><a href="../kontakt">kontakt</a></li>
	<li><a href="../pvv/">wiki</a></li>
</nav>