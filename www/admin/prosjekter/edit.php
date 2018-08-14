<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../../inc/navbar.php';
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';

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
	'Kult Prosjekt',
	'',
	'kåre knoll',
	'pvvadmin',
	'drift@pvv.ntnu.no',
	0
);
if($new == 0){
	$project = $projectManager->getByID($projectID);
}

$members = $projectManager->getProjectMembers($projectID);
$owner = [
	'name' => '',
	'uname' => '',
	'mail' => '',
];
foreach($members as $i => $data){
	if($data['owner']){
		$owner = $data;
	}
}
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">
<title>Prosjektadministrasjonsverkstedet</title>

<header>Prosjekt&shy;administrasjons&shy;verk&shy;stedet</header>

<body>
	<nav>
		<?php echo navbar(3, 'admin'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Prosjektadministrasjon</h2>
		<hr class="ruler">

		<h2><?= ($new == 1 ? "Nytt prosjekt" : "Rediger prosjekt"); ?></h2>

		<form action="update.php", method="post" class="gridsplit5050">
			<div class="gridl">
				<p class="subtitle">Tittel</p>
				<?= '<input type="text" name="title" value="' . $project->getName() . '" class="boxinput">' ?><br>

				<p class="subtitle">Beskrivelse (<i>markdown</i>)</p>
				<textarea name="desc" cols="40" rows="5" class="boxinput"><?= implode($project->getDescription(), "\n"); ?></textarea>
			</div>

			<div class="gridr noborder">
				<p class="subtitle">Prosjektleder (Brukernavn)</p>
				<?= '<input type="text" name="organiser" value="' . $owner['uname'] . '" class="boxinput">' ?><br>

				<p class="subtitle">Prosjektleder (Navn)</p>
				<?= '<input type="text" name="organisername" value="' . $owner['name'] . '" class="boxinput">' ?>

				<p class="subtitle">Prosjektleder E-post</p>
				<?= '<input type="text" name="organiseremail" value="' . $owner['mail'] . '" class="boxinput">' ?><br>

				<p class="subtitle">Aktiv</p>
				<?= '<input type="checkbox" '. ($project->getActive() ? 'checked' : '') . ' name="active"/>' ?>
			</div>

			<?= '<input type="hidden" name="id" value="' . $project->getID() . '" />' ?>

			<?php if(!$new){ ?>
				<div style="grid-column: span 2;">
					<hr class="ruler">
				</div>

				<h2 style="grid-column: span 2">Prosjektmedlemmer</h2>

				<table class="userlist" style="grid-column: span 2;">
					<tr><th>Brukernavn</th><th>Navn</th><th>Rolle</th></tr>
					<?php foreach($members as $i => $data) { ?>
						<tr>
							<td><?= $data['uname']; ?></td>
							<td><?= $data['name']; ?></td>
							<td><?= $data['role']; ?></td>
						</tr>
					<?php } ?>

					<tr class="newuserrow">
						<td class="newuserelement"><input type="text" name="newuser_uname"></td>
						<td class="newuserelement"><input type="text" name="newuser_name"></td>
						<td class="newuserelement"><input type="text" name="newuser_role"></td>
					</tr>
				</table>
			<?php } ?>
			
			<div class="allgrids" style="margin-top: 2em;">
				<hr class="ruler">

				<input type="submit" class="btn" value="Lagre">
			</div>
		</form>
		<p>
	</main>
</body>
