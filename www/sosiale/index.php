<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../src/_autoload.php';
$agenda = new \pvv\side\Agenda([
		new \pvv\side\social\NerdepitsaActivity,
		new \pvv\side\social\AnimekveldActivity,
		new \pvv\side\social\BrettspillActivity,
	]); ?>
?><!DOCTYPE html>
<html lang="no">
<title>Sosialverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">

<nav>
	<li><a href="../index.php">hjem</a></li>
	<li><a href="../kurs/index.html">kurs</a></li>
	<li><a href="../prosjekt/index.html">prosjekt</a></li>
	<li class="active"><a href="../sosiale/index.html">sosiale</a></li>
	<li><a href="../wiki/index.html">wiki</a></li>
</nav>

<header>Sosial&shy;verk&shy;stedet</header>

<main>

<?php $limit = PHP_INT_MAX; ?>
<?php foreach($agenda->getNextOfEach(new \DateTimeImmutable) as $event) { ?>

<article>
	<h2><img src="<?= $event->getImageURL() ?>"><em><?= $event->getRelativeDate() ?></em> <a href="<?= $event->getURL() ?>"><?= $event->getName() ?></a></h2>
	<ul class="subtext">
		<li>Tid: <strong><?= trim(strftime('%e. %b %H.%M', $event->getStart()->getTimeStamp())) ?></strong>
		<li>Sted: <strong><?= $event->getLocation() ?></strong>
		<li>Arrangør: <strong><?= $event->getOrganiser() ?></strong>
	</ul>

	<?php $description = $event->getDescription(); ?>
	<?php array_splice($description, $limit); ?>
	<p><?= implode($description, "</p>\n<p>") ?></p>

	<p><a class="btn" href="#">Påminn meg</a>
</article>

<?php if ($limit > 4) {$limit = 4;} else $limit = 2; ?>
<?php } ?>

</main>
