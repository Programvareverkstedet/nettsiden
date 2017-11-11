<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require_once __DIR__ . '/../../inc/navbar.php';
require_once __DIR__ . '/../../src/_autoload.php';
require_once __DIR__ . '/../../sql_config.php';

use \pvv\side\Agenda;
$months_translations = ['Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember'];
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
$days_before_the_first = (new DateTime($year."-".$month."-01"))->format("w") - 1;
if ($days_before_the_first==-1) {$days_before_the_first = 6;}
$day_of_month = ($month == date("m"))
	? date("j")
	: -1;
$days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

?><!DOCTYPE html>
<html lang="no">
<title>Kalenderverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<link rel="stylesheet" href="../css/calendar.css">

<header>Kalender&shy;verk&shy;stedet</header>

<main>

<article>
	<h2 style="text-align:center;">Aktiviteter for <?=$months_translations[$month-1]?> <?=$year?></h2>
	
	<p><?php
	$pmonth = $month-1;
	$nmonth = $month+1;
	$pyear=$year;
	$nyear=$year;
	if ($pmonth==0) {$pmonth=12; $pyear--;}
	if ($nmonth==13) {$nmonth=1; $nyear++;}
	?>
	<a class="btn" href="../kalender?year=<?=$pyear?>&amp;month=<?=$pmonth?>">Forrige måned</a>
	<a class="btn" style="float:right;" href="../kalender?year=<?=$nyear?>&amp;month=<?=$nmonth?>">Neste måned</a>
	</p>
	
	
	<figure class="calendar">
	<ul>
	<li class="header">Mandag
	<li class="header">Tirsdag
	<li class="header">Onsdag
	<li class="header">Torsdag
	<li class="header">Fredag
	<li class="header">Lørdag
	<li class="header">Søndag
	
	<?php if ($days_before_the_first != 0) { ?>
	<li class="outOfMonth" style="grid-column: 1/<?=$days_before_the_first+1?>;">
	<?php } ?>
	
	<?php for ($day=1; $day <= $days_in_month; $day++) { ?>
		<?php $events = $agenda->getEventsBetween(
			new DateTimeImmutable("$year-$month-$day 00:00:00"),
			new DateTimeImmutable("$year-$month-$day 23:59:59")); ?>
		<?php if ($day==$day_of_month) { ?>
			<li class="active">
		<?php } else { ?>
			<li>
		<?php } ?>
		<?php if (sizeof($events)!=0) { ?>
			<a href="../aktiviteter/?<?="year=$year&amp;month=$month&amp;day=$day"?>"><div>
				<?= $day ?>.
				<?php foreach($events as $event) { ?>
					<section><?=$event->getName()?></section>
				<?php } ?>
			</div></a>
		<?php } else { ?>
			<?= $day ?>.
		<?php } ?>
	<?php } ?>
	
	</ul>
	</figure>
	
</article>

</main>

<nav>
	<?= navbar(1, 'kalender'); ?>
	<?= loginbar(); ?>
</nav>
