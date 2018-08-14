<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../inc/navbar.php';
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';

require_once(__DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$projectManager = new \pvv\side\ProjectManager($pdo);
$projects = $projectManager->getByOwner($attrs['uid'][0]);

$page = 1;
if(isset($_GET['page'])){
	$page = $_GET['page'];
}

$filter = '';
if(isset($_GET['filter'])){
	$filter = $_GET['filter'];
}

// filter
$projects = array_values(array_filter(
	$projects,
	function($project) use ($filter){
		return (preg_match('/.*'.$filter.'.*/i', $project->getName()) or preg_match('/.*'.$filter.'.*/i', implode(" ", $project->getDescription())));
	}
));
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<link rel="stylesheet" href="../css/admin.css">
<title>Prosjektverkstedet</title>

<header>Prosjekt&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?= navbar(1, 'prosjekt'); ?>
		<?= loginbar(); ?>
	</nav>

	<main class="gridsplit">
		<div class="gridl">
			<h2 class="no-chin">Mine Prosjekter</h2>

			<ul class="event-list">
				<?php
					$counter = 0;
					$pageLimit = 8;

					for($i = ($pageLimit * ($page - 1)); $i < count($projects); $i++){
						if($counter == $pageLimit){
							break;
						}

						$project = $projects[$i];
						$projectID = $project->getID();
				?>

					<li>
						<div class="event">
							<div class="event-info">
								<a href="edit.php?id=<?= $project->getID() ?>">
									<h3 class="no-chin"><?= $project->getName()?></h3>
								</a>
								<p style="text-decoration: none;"><?= implode("<br>", array_slice($project->getDescription(), 0, 4)); ?></p>
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
					echo '<a class="btn float-left" href="?page=' . ($page - 1) . '&filter=' . urlencode($filter) . '">Forrige side</a>';
				}

				if(($counter == $pageLimit) and (($pageLimit * $page) < count($projects))){
					echo '<a class="btn float-right" href="?page=' . ($page + 1) . '&filter=' . urlencode($filter) . '">Neste side</a>';
				}
			?>
		</div>

		<div class="gridr">
			<h2>Verktøy</h2>
			<a class="btn" href="edit.php?new=1">Lag prosjekt</a>
			<h2>Filter</h2>
			<form action="mine.php" method="get">
				<p class="no-chin">Navn</p>
				<?= '<input type="text" name="filter" class="boxinput" value="' . $filter . '">' ?><br>

				<div style="margin-top: 2em;">
					<input type="submit" class="btn" value="Filtrer"></input>
				</div>
			</form>
		</div>
	</main>
</body>
