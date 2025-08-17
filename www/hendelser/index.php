<?php

namespace pvv\side;

require_once \dirname(__DIR__, 2) . implode(\DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

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
		<?php echo navbar(1, 'hendelser'); ?>
		<?php echo loginbar($sp, $pdo); ?>
	</nav>
	<main>
		<h1 style="pointer-events:none; text-align: left;">Hendelser</h1>
		<center>
			<a style="padding-left: 2em; padding-right: 2em;" class="btn" style="" href="../kalender/">Kalender</a>
		</center>
		<?php
      $description_paragraphs = 2; // description length
      foreach ($agenda->getNextDays() as $period => $events) {
        if ($events) { ?>
				<h2 style="text-align: left;"><?php echo $translation[$period]; ?></h2>
				<ul class="events">
				<?php foreach ($events as $event) {?>
				<li style="border-color: <?php echo $event->getColor(); ?>">
					<h4><strong>
						<?php if ($event->getURL()) { ?>
							<a href="<?php echo $event->getURL(); ?>"><?php echo $event->getName(); ?></a>
						<?php } else { ?>
							<?php echo $event->getName(); ?>
						<?php } ?>
					</strong></h4>

					<?php $description = $event->getDescription(); ?>
					<?php if ($description_paragraphs) {
            array_splice($description, $description_paragraphs);
					} ?>

					<?php
            $Parsedown = new \Parsedown();
            echo $Parsedown->text(implode("\n", $description));
          ?>

					<ul class="subtext">
						<li>Tid: <strong><?php echo Agenda::getFormattedDate($event->getStart()); ?></strong></li>
						<li>Sted: <strong><?php echo $event->getLocation(); ?></strong></li>
						<li>Arrangør: <strong><?php echo $event->getOrganiser(); ?></strong></li>
					</ul>
				</li>
				<?php } ?>
				</ul>
			<?php } ?>
		<?php } ?>

	</main>
</body>
