<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$projectID = 0;
if(isset($_GET['id'])){
	$projectID = $_GET['id'];
}else{
	echo 'No project ID provided';
	exit();
}

$projectManager = new \pvv\side\ProjectManager($pdo);
$project = $projectManager->getByID($projectID);
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../../css/normalize.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/events.css">
	<link rel="stylesheet" href="../../css/projects.css">
</head>

<body>
	<nav>
		<?php echo navbar(2, 'prosjekt'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main class="contentsplit">
		<div class="gridr">
			<h2><?= $project->getName(); ?></h2>
			<p><?= implode($project->getDescription(), "<br>"); ?></p>
		</div>

		<div class="gridl">
			<div class="projectlead">
				<h2>Prosjektledelse</h2>
				<div class="projectowner">
					<p>Prosjekteier</p>
					<p class="ownername"><?= $project->getOwner() ?></p>
					<p class="owneruname"><?= $project->getOwnerUName(); ?></p>
					<p class="owneremail"><?= $project->getOwnerEmail(); ?></p>
				</div>
			</div>

			<h2>Medlemmer</h2>
		</div>
	</main>
</body>