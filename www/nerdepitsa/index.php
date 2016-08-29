<!DOCTYPE html>
<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';
use \pvv\side\Agenda;
?>
<html lang="no">
<title>Sosialverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">

<header>Sosial&shy;verk&shy;stedet</header>

<main>

<?php
$activity = new \pvv\side\social\NerdepitsaActivity;
$nextEvent = $activity->getNextEventFrom(new DateTimeImmutable);
?>

<article>


	<h2><img src="../sosiale/nerdepitsa.jpg"><em><?= $nextEvent->getRelativeDate()?></em> Nerdepitsa</h2>
	<ul class="subtext">
		<li>Tid:
		<strong>
			<?= Agenda::getFormattedDate($nextEvent->getStart());?>
		</strong>
		<li>Sted:
		<strong>
			<?= $nextEvent->getLocation();?>
		</strong>
		<li>Arrangør:
		<strong>
			<?= $nextEvent->getOrganiser();?>
		</strong>
	</ul>

	<?= implode($nextEvent->getDescription(), "<p>\n</p>")?> 
</article>

</main>

<nav><ul>
	<li><a href="../">hjem</a></li>
	<li><a href="../kurs/">kurs</a></li>
	<li><a href="../prosjekt/">prosjekt</a></li>
	<li class="active"><a href="../sosiale/">sosiale</a></li>
	<li><a href="../wiki/">wiki</a></li>
</nav>
