<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../../inc/navbar.php';
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if(!$userManager->hasGroup($uname, 'aktiviteter')){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}

$customActivity = new \pvv\side\DBActivity($pdo);
$events = $customActivity->getAllEvents();

$page = 1;
if(isset($_GET['page'])){
	$page = $_GET['page'];
}

$filterTitle = '';
if(isset($_GET['title'])){
	$filterTitle = $_GET['title'];
}

$filterOrganiser = '';
if(isset($_GET['organiser'])){
	$filterOrganiser = $_GET['organiser'];
}

// filter
$events = array_values(array_filter(
	$events,
	function($event) use ($filterTitle, $filterOrganiser){
		return (preg_match('/.*'.$filterTitle.'.*/i', $event->getName()) and preg_match('/.*'.$filterOrganiser.'.*/i', $event->getOrganiser()));
	}
));
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/nav.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">
<meta name="theme-color" content="#024" />
<title>Aktivitetsadministrasjonsverkstedet</title>

<header>Aktivitets&shy;administrasjons&shy;verk&shy;stedet</header>

<body>
	
	<nav>
		<?php echo navbar(2, 'admin'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Aktivitetsadministrasjon</h2>
		<hr class="ruler">

		<div class="gridsplit">
			<div class="gridl">
				<h2 class="no-chin">Aktive aktiviteter</h2>
				<p class="subnote">Gjentagende aktiviteter vises ikke</p>

				<ul class="event-list">
					<?php
						$counter = 0;
						$pageLimit = 10;

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
									<?php
									$Parsedown = new \Parsedown();
									echo $Parsedown->text(implode("\n", $event->getDescription()));
									?>
								</div>

								<div class="event-actions">
									<a class="btn" href="edit.php?id=<?= $eventID ?>">Rediger</a><br>
									<a class="btn" href="delete.php?id=<?= $eventID ?>" onclick="return confirm('Knallsikker? (ID: <?= $eventID ?>)');">Slett</a>
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
						echo '<a class="btn float-left" href="?page=' . ($page - 1) . '&title=' . urlencode($filterTitle) . '&organiser=' . urlencode($filterOrganiser) . '">Forrige side</a>';
					}

					if(($counter == $pageLimit) and (($pageLimit * $page) < count($events))){
						echo '<a class="btn float-right" href="?page=' . ($page + 1) . '&title=' . urlencode($filterTitle) . '&organiser=' . urlencode($filterOrganiser) .  '">Neste side</a>';
					}
				?>
			</div>

			<div class="gridr">
				<h2>Verktøy</h2>
				<a class="btn adminbtn" href="edit.php?new=1">Legg inn ny aktivitet</a>
				<h2>Filter</h2>
				<form action="." method="get">
					<p class="no-chin">Navn</p>
					<?= '<input type="text" name="title" class="boxinput" value="' . $filterTitle . '">' ?><br>
					<p class="no-chin">Organisator</p>
					<?= '<input type="text" name="organiser" class="boxinput" value="' . $filterOrganiser . '">' ?><br>

					<div style="margin-top: 2em;">
						<input type="submit" class="btn" value="Filtrer"></input>
					</div>
				</form>
			</div>
		</div>
	</main>
</body>
