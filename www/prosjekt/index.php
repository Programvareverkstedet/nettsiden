<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$translation = ['i dag', 'i morgen', 'denne uka', 'neste uke', 'denne måneden', 'neste måned'];
$projectManager = new \pvv\side\ProjectManager($pdo);
$projects = $projectManager->getAll();
?>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Prosjektverkstedet</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/nav.css">
	<link rel="stylesheet" href="../css/splash.css">
	<link rel="stylesheet" href="../css/projects.css">
</head>

<body>
	<nav>
		<?php echo navbar(1, 'prosjekt'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
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
			<hr class="projects-divider">

			<?php
				$randProjects = array_rand($projects, min(6, count($projects)));
				if (!is_array($randProjects)) {
					$randProjects = [$randProjects];
				};
				foreach($randProjects as $i) {
					$project = $projects[$i];
					$owner = $projectManager->getProjectOwner($project->getID());
			?>

			<div class="project-card">
				<div class="card-content">
					<h4 class="project-title"><?= $project->getName(); ?></h4>
					<p><?= $project->getDescription()[0]; ?></p>
				</div>
				<p class="project-organizer">Organisert av<br><?= $owner['name']; ?></p>
			</div>
			<?php } ?>
		<?php
			}
		?>
	</main>
</body>
