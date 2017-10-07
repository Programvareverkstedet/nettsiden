<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
error_reporting(E_ALL);
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$customActivity = new \pvv\side\DBActivity($pdo);
?>

<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">

<nav><ul>
	<li class="active"><a href="index.php">hjem</a></li>
	<li><a href="aktiviteter/">aktiviteter</a></li>
	<li><a href="kontakt">kontakt</a></li>
	<li><a href="pvv/">wiki</a></li>
</nav>

<header class="admin">Aktivitets&shy;administrasjon</header>

<main>

<article class="gridsplit">
	<div class="gridl">
		<h2 class="no-chin">Aktive aktiviteter</h2>
		<p class="subnote">Gjentagende aktiviteter vises ikke</p>

		<ul class="event-list">
			<?php foreach($customActivity->getAllEvents() as $event){
				$eventID = $event->getID();
			?>
				<li>
					<div class="event admin">
						<div class="event-info">
							<h3 class="no-chin"><?= $event->getName() . " (" . $eventID . ")"; ?></h3>
							<p class="subnote"><?= $event->getStart()->format("(Y-m-d H:i:s)") . " - " . $event->getStop()->format("(Y-m-d H:i:s)"); ?></p>
							<p><?= implode($event->getDescription(), "</p>\n<p>"); ?></p>
						</div>

						<div class="event-actions">
							<a href="/">🖊</a> <!-- emojis are for big boys -->
							<?php
								echo '<a href="./delete.php?id=' . $eventID . '" onclick="return confirm(\'Knallsikker? (ID: ' . $eventID . ')\');">🗑</a>';
							?>
						</div>
					</div>
				</li>
			<?php } ?>
		</ul>
	</div>

	<div class="gridr">
		<h2>Verktøy</h2>
		<a class="btn adminbtn" href="./ny">Legg inn ny aktivitet</a>
	</div>
</article>

</main>