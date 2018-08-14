<?php namespace pvv\side;
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$translation = ['I dag', 'I morgen', 'Denne uka', 'Neste uke', 'Denne måneden', 'Neste måned'];
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
<title>Hendelsesverkstedet</title>

<header>Hendelses&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?= navbar(1, 'hendelser'); ?>
		<?= loginbar($sp, $pdo); ?>
	</nav>
	<main>
		<h2 style="pointer-events:none; text-align: left;">Hendelser</h2>
		<div style="text-align: center; margin-top: -2.5em;">
			<a style="padding-left: 2em; padding-right: 2em;" class="btn" style="" href="../kalender/">Kalender</a>
		</div>
		<?php
		$description_paragraphs = 2; //description length
		foreach($agenda->getNextDays() as $period => $events) {
			if ($events) { ?>
				<h2 style="text-align: left;"><?= $translation[$period] ?></h2>
				<ul class="events">
				<?php foreach($events as $event) {?>
				<li style="border-color: <?= $event->getColor() ?>">
					<h4><strong>
						<?php if ($event->getURL()) { ?>
							<a href="<?= $event->getURL() ?>"><?= $event->getName() ?></a>
						<?php } else { ?>
							<?= $event->getName() ?>
						<?php } ?>
					</strong></h4>

					<?php $description = $event->getDescription(); ?>
					<?php if ($description_paragraphs) array_splice($description, $description_paragraphs); ?>
					
					<?php
					$Parsedown = new \Parsedown();
					echo $Parsedown->text(implode("\n", $description));
					?>

					<ul class="subtext">
						<li>Tid: <strong><?= Agenda::getFormattedDate($event->getStart()) ?></strong></li>
						<li>Sted: <strong><?= $event->getLocation() ?></strong></li>
						<li>Arrangør: <strong><?= $event->getOrganiser() ?></strong></li>
					</ul>
				</li>
				<?php } ?>
				</ul>
			<?php } ?>
		<?php } ?>
		
		<div style="text-align: center; margin-bottom: 2em;">
			<a style="padding-left: 2em; padding-right: 2em;" class="btn" style="" href="../kalender/">Kalender</a>
		</div>
		
	</main>
</body>
