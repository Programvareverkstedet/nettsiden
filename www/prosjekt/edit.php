<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../inc/navbar.php';
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../config.php';

require_once __DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';
$as = new \SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();

$pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$projectManager = new \pvv\side\ProjectManager($pdo);

$new = 0;
if(isset($_GET['new'])){
	$new = $_GET['new'];
}

$projectID = 0;
if(isset($_GET['id'])){
	$projectID = $_GET['id'];
}else if($new == 0){
	echo "\nID not set";
	exit();
}

$project = new \pvv\side\Project(
	0,
	'Nytt Prosjekt',
	'',
	$attrs["cn"][0],
	$attrs["uid"][0],
	$attrs["mail"][0],
	1
);
if($new == 0){
	$project = $projectManager->getByID($projectID);
	$owner = $projectManager->getProjectOwner($projectID);

	if($owner['uname'] != $attrs["uid"][0]){
		header('HTTP/1.0 403 Forbidden');
		echo "wrong user";
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/nav.css">
<link rel="stylesheet" href="../css/projects.css">
<meta name="theme-color" content="#024" />
<title>Prosjektverkstedet</title>

<header>Prosjekt&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(1, 'prosjekt'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Nytt prosjekt</h2>

		<form action="update.php", method="post">
			<p class="subtitle no-chin">Prosjektnavn</p>
			<p class="subnote">Gi prosjektet ditt et passende navn</p>
			<input class="wide" type="text" name="title" value="<?= $project->getName() ?>" class="boxinput"><br>

			<p class="subtitle no-chin">Beskrivelse (<i style="opacity:0.5;">markdown</i>)</p>
			<p class="subnote no-chin">Hva går prosjektet ditt ut på?</p>
			<p class="subnote">De første to linjene blir vist på prosjektkortet, prøv å gjøre de til et fint sammendrag eller intro!</p>
			<textarea class="tall" name="desc" style="width:100%" rows="8" class="boxinput"><?= implode("\n", $project->getDescription()); ?></textarea>

			<?= '<input type="hidden" name="id" value="' . $project->getID() . '" />' ?>
			<input type="hidden" name="active" value="1"/>

			<div style="margin-top: 0.2em;">
				<hr class="ruler">
				 <input type="submit" class="btn" value="<?= ($new ? 'Opprett prosjekt' : 'Lagre endringer') ?>"></input>
				 <?php if (!$new){?><input type="submit" class="btn" name="delete" value="Slett"></input><?php } ?>
			</div>
		</form>
	</main>
</body>
