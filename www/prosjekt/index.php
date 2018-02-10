<?php
error_reporting(E_ALL);
date_default_timezone_set('Europe/Oslo');
require __DIR__ . '/../../inc/navbar.php';
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';

$translation = ['i dag', 'i morgen', 'denne uka', 'neste uke', 'denne måneden', 'neste måned'];
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$projectManager = new \pvv\side\ProjectManager($pdo);
$projects = $projectManager->getAll();
?>
<!DOCTYPE html>
<html lang="no">
<title>Prosjektverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/nav.css">
<link rel="stylesheet" href="../css/splash.css">

<header>Prosjekt&shy;verk&shy;stedet</header>

<main>

<article class="threed">
<h2>Prosjekter</h2>
<?php
	if(count($projects) == 0){
?>
	<p>PVV har for øyeblikket ingen aktive prosjekter. Tenker du at noe bør gjøres? Har du en kul ide for noe PVV kan samarbeide om? Sett opp et prosjekt!</p>
	<br>
	<a class="btn" href="edit.php?new=1">Lag prosjekt</a>
	<a class="btn" href="mine.php">Mine prosjekter</a>
<?php
	}else{
?>
	<p>Lyst til å gjøre noe kult? Her er et utvalg av de prosjektene som PVVere har laget. Mangler det noe, eller brenner du for noe annet? Sett opp et eget prosjekt!</p>
	<a class="btn" href="edit.php?new=1">Lag prosjekt</a>
	<a class="btn" href="mine.php">Mine prosjekter</a>

	<ul class="calendar-events">
		<?php
			$randProjects = array_rand($projects, min(3, count($projects)));
			if (!is_array($randProjects)) {
				$randProjects = [$randProjects];
			};
			foreach($randProjects as $i) {
				$project = $projects[$i];
		?>

		<li>
			<p class="noborder no-chin"><?= "<a href=\"project/?id=" . $project->getID() . "\">" . $project->getName() . "</a>"; ?></p>
			<p class="subnote"><?= "Organisert av: " . $project->getOwner(); ?></p>
			<span>
				<p><?= $project->getDescription(); ?></p>
			</span>
		</li>

		<?php } ?>
	</ul>
<?php
	}
?>
</article>

</main>

<nav>
	<?= navbar(1, 'prosjekt'); ?>
	<?= loginbar(); ?>
</nav>
