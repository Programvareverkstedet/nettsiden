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

$members = $projectManager->getProjectMembers($projectID);
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
				<div class="projectmember">
					<p>Prosjekteier</p>
					<p class="membername"><?= $project->getOwner() ?></p>
					<p class="memberuname"><?= $project->getOwnerUName(); ?></p>
					<p class="memberemail"><?= $project->getOwnerEmail(); ?></p>
				</div>
			</div>

			<div class="projectmembers">
				<h2>Medlemmer</h2>
				<?php foreach($members as $i => $data){ ?>
					<div class="projectmember">
						<p><?= $data['role'] ?></p>
						<p class="membername"><?= $data['name'] ?></p>
						<p class="memberuname"><?= $data['uname'] ?></p>
					</div>
				<?php } ?>
			</div>
		</div>
	</main>
</body>