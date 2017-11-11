<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
error_reporting(E_ALL);
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';
require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$attrs = $as->getAttributes();

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">

<nav>
	<ul>
	<li><a href="../../index.php">hjem</a></li>
	<li><a href="../../kalender/">kalender</a></li>
	<li><a href="../../aktiviteter/">aktiviteter</a></li>
	<li><a href="../../prosjekt/">prosjekter</a></li>
	<li><a href="../../kontakt">kontakt</a></li>
	<li><a href="../../pvv/">wiki</a></li>
	</ul>

	<?php
		$attr = $as->getAttributes();
		if($attr){
			$uname = $attr["uid"][0];
			echo '<p class="login">logget inn som: ' . $uname . '</p>';
		}else{
			echo '<a class="login" href="' . $as->getLoginURL() . '">logg inn</a>';
		}
	?>
</nav>

<header class="admin">Prosjekt&shy;administrasjon</header>

<main>

<article class="gridsplit">
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
			?>

				<li>
					<div class="event admin">
						<div class="event-info">
							<h3 class="no-chin"><?= $project->getName() . " (ID: " . $projectID . ")"; ?></h3>
							<p class="subnote"><?= 'Organisert av: ' . $project->getOwner(); ?></p>
							<p><?= $project->getDescription(); ?></p>
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
