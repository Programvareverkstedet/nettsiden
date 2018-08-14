<?php namespace pvv\side;
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<title>Aktivitetsverkstedet</title>

<header>Aktivitets&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(1, 'aktiviteter'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<?php
		use \DateTimeImmutable;
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
				<?php if (\pvv\side\Agenda::isToday($event->getStart())) { ?><strong><?php } ?>
				<em><?= $event->getRelativeDate() ?></em>
				<?php if (\pvv\side\Agenda::isToday($event->getStart())) { ?></strong><?php } ?>
				<?php if ($event->getURL()) { ?>
				<a href="<?= $event->getURL() ?>"><?= $event->getName() ?></a>
				<?php } else { ?>
				<?= $event->getName() ?>
				<?php } ?>
				<?php if ($event->getImageURL()) { ?>
				<img src="<?= $event->getImageURL() ?>">
				<?php } ?>
			</h2>
			<ul class="subtext">
				<li>Tid: <strong><?= Agenda::getFormattedDate($event->getStart()) ?></strong></li>
				<li>Sted: <strong><?= $event->getLocation() ?></strong></li>
				<li>Arrangør: <strong><?= $event->getOrganiser() ?></strong></li>
			</ul>

			<?php $description = $event->getDescription(); ?>
			<?php if ($limit) array_splice($description, $limit); ?>
			<?php
			$Parsedown = new \Parsedown();
			echo $Parsedown->text(implode("\n", $description));
			?>
		</article>

		<?php } ?>
	</main>

</body>
