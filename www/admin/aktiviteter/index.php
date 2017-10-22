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

$page = 1;
if(isset($_GET['page'])){
	$page = $_GET['page'];
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">

<nav><ul>
	<li class="active"><a href="index.php">hjem</a></li>
	<li><a href="aktiviteter/">aktiviteter</a></li>
	<li><a href="../prosjekt/">prosjekter</a></li>
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
			<?php
				$counter = 0;
				$pageLimit = 4;
				$events = $customActivity->getAllEvents();

				for($i = ($pageLimit * ($page - 1)); $i < count($events) ;$i++){
					if($counter == $pageLimit){
						break;
					}

					$event = $events[$i];
					$eventID = $event->getID();
			?>

				<li>
					<div class="event admin">
						<div class="event-info">
							<h3 class="no-chin"><?= $event->getName() . " (ID: " . $eventID . ")"; ?></h3>
							<p class="subnote">
								<?= $event->getStart()->format("(Y-m-d H:i:s)") . " - " . $event->getStop()->format("(Y-m-d H:i:s)"); ?>
							</p>
							<p><?= implode($event->getDescription(), "</p>\n<p>"); ?></p>
						</div>

						<div class="event-actions">
							<!-- emojis are for big boys -->
							<?= '<a href="edit.php?id=' . $eventID . '">🖊</a>'; ?>
							<?= '<a href="delete.php?id=' . $eventID . '" onclick="return confirm(\'Knallsikker? (ID: ' . $eventID . ')\');">🗑</a>'; ?>
						</div>
					</div>
				</li>

			<?php
					$counter++;
				}
			?>
		</ul>

		<?php
			if($page != 1){
				echo '<a class="btn float-left" href="?page=' . ($page - 1) . '">Forrige side</a>';
			}

			if(($counter == $pageLimit) and (($pageLimit * $page) < count($events))){
				echo '<a class="btn float-right" href="?page=' . ($page + 1) . '">Neste side</a>';
			}
		?>
	</div>

	<div class="gridr">
		<h2>Verktøy</h2>
		<a class="btn adminbtn" href="edit.php?new=1">Legg inn ny aktivitet</a>
	</div>
</article>

</main>