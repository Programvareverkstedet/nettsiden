<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<link rel="stylesheet" href="../css/calendar.css">
<title>Kalenderverkstedet</title>

<header>Kalender&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(1, 'hendelser'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2 style="text-align:center;">PVV Kalender for <?=$months_translations[$month-1]?> <?=$year?></h2>
	
		<div class="pagination_bar"><?php
		$pmonth = $month-1;
		$nmonth = $month+1;
		$pyear=$year;
		$nyear=$year;
		if ($pmonth==0) {$pmonth=12; $pyear--;}
		if ($nmonth==13) {$nmonth=1; $nyear++;}
		?>
		<a class="btn noselect" href="../kalender?year=<?=$pyear?>&amp;month=<?=$pmonth?>">Forrige måned</a>
		<a class="btn noselect" href="../kalender?year=<?=$nyear?>&amp;month=<?=$nmonth?>">Neste måned</a>
		</div>
	
		<figure class="calendar">
			<ul>
				<li class="header noselect">mandag
				<li class="header noselect">tirsdag
				<li class="header noselect">onsdag
				<li class="header noselect">torsdag
				<li class="header noselect">fredag
				<li class="header noselect">lørdag
				<li class="header noselect">søndag
	
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
							<span class="noselect day"><?= $day ?>.</span>
							<?php foreach($events as $event) { ?>
								<section style="background: <?=$event->getColor()?>"><?=$event->getName()?></section>
							<?php } ?>
						</div></a>
					<?php } else { ?>
						<span class="noselect day"><?= $day ?>.</span>
					<?php } ?>
				<?php } ?>
	
			</ul>
		</figure>
	</main>
<body>
