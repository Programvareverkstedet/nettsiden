<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../../inc/navbar.php';
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$customActivity = new \pvv\side\DBActivity($pdo);
$events = $customActivity->getAllEvents();

$page = 1;
if(isset($_GET['page'])){
	$page = $_GET['page'];
}

$filterTitle = '';
if(isset($_POST['title'])){
	$filterTitle = $_POST['title'];
}

$filterOrganiser = '';
if(isset($_POST['organiser'])){
	$filterOrganiser = $_POST['organiser'];
}

// filter
$events = array_values(array_filter(
	$events,
	function($event) use ($filterTitle, $filterOrganiser){
		return (preg_match('/.*'.$filterTitle.'.*/i', $event->getName()) and preg_match('/.*'.$filterOrganiser.'.*/i', $event->getOrganiser()));
	}
));
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">

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
		<h2>Filter</h2>
		<form action="." method="post">
			<p class="no-chin">Navn</p>
			<?= '<input type="text" name="title" class="boxinput" value="' . $filterTitle . '">' ?><br>
			<p class="no-chin">Organisator</p>
			<?= '<input type="text" name="organiser" class="boxinput" value="' . $filterOrganiser . '">' ?><br>

			<div style="margin-top: 2em;">
				<input type="submit" class="btn" value="Filtrer"></input>
			</div>
		</form>
	</div>
</article>

</main>

<nav>
	<?= navbar(2); ?>
	<?= loginbar(); ?>
</nav>
