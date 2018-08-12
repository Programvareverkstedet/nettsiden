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
		<h2>Projekter</h2>
		<p>
			PVV er et kult miljø der du kan bli med på mye rart.
			På denne siden har vi en liten oversikt over forskjellige prosjekter og organer i PVV.
		</p>
		<br>
		<br>
		<h2>Faste poster</h2>
		<div class="projects-container">
			<a class="nostyle" href="../styret/"><div class="project-card" style="border-color:#b93;">
				<div class="card-content">
					<h4 class="project-title">Styret</h4>
					<p>
						Styret har ansvaret for den daglige driften av PVV, og har myndighet som gitt i PVVs lover.
						Lederen for PVV velges om høsten og sitter i et år. Resten av styret velges for et halvår om
						gangen, selv om praksis er at bare mindre justeringer gjøres i vårsemesteret. 
					</p>
					<p class="project-organizer">Organisert av Styreleder</p>
				</div>
			</div></a>
			<a class="nostyle" href="../drift/"><div class="project-card" style="border-color:#184;">
				<div class="card-content">
					<h4 class="project-title">Drift</h4>
					<p>
						Drift har ansvaret for å drive maskinene på PVV. 
						Driftsgruppen har ingen strenge krav til aktivitet eller erfaring for å bli medlem,
						så selv om du er ny i virket går det fint an å bare observere og absorbere i begynnelsen.
						Vi vil gjøre vårt beste for å gi god hjelp og service til våre brukere.
					</p>
					<p class="project-organizer">Organisert av Driftskordinator</p>
				</div>
			</div></a>
			<?php /*Her kan vi legge til PR og TriKom hvis det er ønskelig*/ ?>
		</div>
		
		<h2>Medlems-prosjekter</h2>
		<?php
			if(count($projects) == 0){
		?>
			<p>PVV har for øyeblikket ingen aktive prosjekter. Tenker du at noe bør gjøres? Har du en kul ide for noe PVV kan samarbeide om? Sett opp et prosjekt!</p>
			<br>
			<center>
				<a class="btn" href="edit.php?new=1">Lag prosjekt</a>
				<a class="btn" href="mine.php">Mine prosjekter</a>
			</center>
			<br>
		<?php
			}else{
		?>
			<p>
				Lyst til å gjøre noe kult? Her er et utvalg av de prosjektene som PVVere har holder på med. Mangler det noe, eller brenner du for noe annet?<br>
				Sett opp et eget prosjekt da vel!
			</p>
			<div class="projects-container">

			<?php
				$randProjects = array_rand($projects, min(6, count($projects)));
				if (!is_array($randProjects)) {
					$randProjects = [$randProjects];
				};
				foreach($randProjects as $i) {
					$project = $projects[$i];
					$owner = $projectManager->getProjectOwner($project->getID());
			?>

			<a class="nostyle" href="info.php?id=<?= $project->getID() ?>"><div class="project-card">
				<div class="card-content">
					<h4 class="project-title"><?= $project->getName(); ?></h4>
					<?php
					$Parsedown = new \Parsedown();
					echo $Parsedown->text(implode("\n", array_slice($project->getDescription(), 0, 2)));
					?>
				</div>
				<p class="project-organizer">Organisert av <?= $owner['name']; ?></p>
			</div></a>
			<?php } ?>
			</div>
			<center>
				<a class="btn" href="edit.php?new=1">Lag prosjekt</a>
				<a class="btn" href="mine.php">Mine prosjekter</a>
			</center>
		<?php
			}
		?>
	</main>
</body>
