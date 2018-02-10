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
<link rel="stylesheet" href="../css/nav.css">
<link rel="stylesheet" href="../css/events.css">

<header>Sosial&shy;verk&shy;stedet</header>

<main>

<?php
$activity = new \pvv\side\social\BrettspillActivity;
$nextEvent = $activity->getNextEventFrom(new DateTimeImmutable);
?>

<article>

<h2><em><?= $nextEvent->getRelativeDate()?></em> Brettspillkveld
	<?php if ($nextEvent->getImageURL()) { ?>
	<img src="<?= $nextEvent->getImageURL() ?>">
	<?php } ?>
</h2>
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
	<!--<li><a href="../prosjekt/">prosjekter</a></li>-->
	<li><a href="../kalender/">kalender</a></li>
	<li class="active"><a href="../aktiviteter/">aktiviteter</a></li>
	<li><a href="../prosjekt/">prosjekter</a></li>
	<li><a href="../kontakt/">kontakt</a></li>
	<li><a href="../pvv/">wiki</a></li>
</nav>
