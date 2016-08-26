<!DOCTYPE html>
<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';
?>
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

<?php
$activity = new \pvv\side\social\BrettspillActivity;
$nextEvent = $activity->getNextEventFrom(new DateTimeImmutable);
?>

<article>

<h2><em><?= $nextEvent->getRelativeDate()?></em> Brettspillkveld</h2>
	<ul class="subtext">
        <li>Tid:
        <strong>
            <?= $nextEvent->getStart()->format('Y-m-d H:i');?>
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
	<p>Er du en hardcore brettspillentusiast eller en nybegynner som har bare spilt ludo? Da er vårt brettspillkveld noe for deg. Vi tar ut et par spill fra vår samling og spiller så mye vi orker. Kom innom!

	<p><a class="btn" href="#b_spill">Vår samling</a>

    <div id="b_spill" class="collapsable">
		<ul>
			<li>Dominion*
			<li>Three cheers for master
			<li>Avalon
			<li>Hanabi
			<li>Cards aginst humanity*
			<li>Citadels
			<li>Munchkin**
			<li>Exploding kittens**
			<li>Aye dark overlord
			<li>Settlers of catan*
			<li>Risk**
			<li>og mange flere...
		</ul>
			<p>*  Vi har flere ekspansjon til spillet
			<P>** Vi har flere varianter av spillet
    </div>

	<p><a class="btn" href="#">Påminn meg</a>
</article>

</main>
