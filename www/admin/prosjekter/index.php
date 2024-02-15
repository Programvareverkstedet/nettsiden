<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../../inc/navbar.php';
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../config.php';

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if(!$userManager->hasGroup($uname, 'prosjekt')){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}

$projectManager = new \pvv\side\ProjectManager($pdo);
$projects = $projectManager->getAll();

$page = 1;
if(isset($_GET['page'])){
	$page = $_GET['page'];
}

$filterTitle = '';
if(isset($_POST['title'])){
	$filterTitle = $_POST['title'];
}

/* Temporarily out of service :<
$filterOrganiser = '';
if(isset($_POST['organiser'])){
	$filterOrganiser = $_POST['organiser'];
}
*/

// filter
$projects = array_values(array_filter(
	$projects,
	function($project) use ($filterTitle){
		return (preg_match('/.*'.$filterTitle.'.*/i', $project->getName()));
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
<title>Prosjektadministrasjonsverkstedet</title>

<header>Prosjekt&shy;administrasjons&shy;verk&shy;stedet</header>

<body>
	<nav>
		<?php echo navbar(2, 'admin'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Prosjektadministrasjon</h2>
		<hr class="ruler">

		<div class="gridsplit">
			<div class="gridl">
				<h2 class="no-chin">Prosjekter</h2>

				<ul class="event-list">
					<?php
						$counter = 0;
						$pageLimit = 4;

						for($i = ($pageLimit * ($page - 1)); $i < count($projects); $i++){
							if($counter == $pageLimit){
								break;
							}

							$project = $projects[$i];
							$projectID = $project->getID();
							$owner = $projectManager->getProjectOwner($projectID);
					?>

						<li>
							<div class="event admin">
								<div class="event-info">
									<h3 class="no-chin"><?= $project->getName() . " (ID: " . $projectID . ")"; ?></h3>
									<p class="subnote"><?= 'Organisert av: ' . $owner['name']; ?></p>
									<?php
									$Parsedown = new \Parsedown();
									echo $Parsedown->text(implode("\n", $project->getDescription()));
									?>
								</div>

								<div class="event-actions">
									<?= '<a href="edit.php?id=' . $projectID . '">🖊</a>'; ?>
									<?= '<a href="delete.php?id=' . $projectID . '" onclick="return confirm(\'Knallsikker? (ID: ' . $projectID . ')\');">🗑</a>'; ?>
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

					if(($counter == $pageLimit) and (($pageLimit * $page) < count($projects))){
						echo '<a class="btn float-right" href="?page=' . ($page + 1) . '">Neste side</a>';
					}
				?>
			</div>

			<div class="gridr">
				<h2>Verktøy</h2>
				<a class="btn adminbtn" href="edit.php?new=1">Legg inn nytt prosjekt</a>
				<h2>Filter</h2>
				<form action="." method="post">
					<p class="no-chin">Prosjektnavn</p>
					<?= '<input type="text" name="title" class="boxinput" value="' . $filterTitle . '">' ?><br>
					<p class="no-chin">Leders brukernavn</p>
					<?= '<input type="text" name="organiser" class="boxinput" value="">' ?><br>

					<div style="margin-top: 2em;">
						<input type="submit" class="btn" value="Filtrer"></input>
					</div>
				</form>
			</div>
		</div>
	</main>

</body>
