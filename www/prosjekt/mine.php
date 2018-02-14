<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
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
$projects = $projectManager->getByUName($attrs['uid'][0]);

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
$projects = array_values(array_filter(
	$projects,
	function($project) use ($filterTitle, $filterOrganiser){
		return (preg_match('/.*'.$filterTitle.'.*/i', $project->getName()) and preg_match('/.*'.$filterOrganiser.'.*/i', $project->getOwner()));
	}
));
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/nav.css">
	<link rel="stylesheet" href="../css/splash.css">
	<link rel="stylesheet" href="../css/admin.css">
</head>

<body>
	<nav>
		<?php echo navbar(1, 'prosjekt'); ?>
		<?php echo loginbar(); ?>
	</nav>

	<main>
		<h2 class="no-chin">Mine Prosjekter</h2>
		<hr class="ruler">

		<div class="gridsplit">
			<div class="gridl">
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
					?>

						<li>
							<div class="event">
								<div class="event-info">
									<h3 class="no-chin"><?= '<a href="edit.php?id=' . $project->getID() . '">' . $project->getName() . '</a>'; ?></h3>
									<p><?= implode($project->getDescription(), "<br>"); ?></p>
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
				<a class="btn" href="edit.php?new=1">Lag prosjekt</a>
				<h2>Filter</h2>
				<form action="." method="post">
					<p class="no-chin">Navn</p>
					<?= '<input type="text" name="title" class="boxinput" value="' . $filterTitle . '">' ?><br>

					<div style="margin-top: 2em;">
						<input type="submit" class="btn" value="Filtrer"></input>
					</div>
				</form>
			</div>
		</div class="gridsplit">
	</main>
</body>
