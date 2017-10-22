<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
error_reporting(E_ALL);
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';

require_once(__DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$projectManager = new \pvv\side\ProjectManager($pdo);

$project = new \pvv\side\Project(
	0,
	'Nytt Prosjekt',
	'',
	$attrs["cn"][0],
	$attrs["uid"][0],
	1
);
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">

<nav><ul>
	<li><a href="index.php">hjem</a></li>
	<li><a href="../kalender/">kalender</a></li>
	<li><a href="aktiviteter/">aktiviteter</a></li>
	<li class="active"><a href="../prosjekt/">prosjekter</a></li>
	<li><a href="kontakt">kontakt</a></li>
	<li><a href="pvv/">wiki</a></li>
</nav>

<header class="admin">Prosjekter</header>

<main>

<article>
	<h2>Nytt prosjekt</h2>

	<form action="update.php", method="post">
		<p class="subtitle no-chin">Prosjektnavn</p>
		<p class="subnote">Gi prosjektet ditt et passende navn</p>
		<?= '<input type="text" name="title" value="' . $project->getName() . '" class="boxinput">' ?><br>

		<p class="subtitle no-chin">Beskrivelse</p>
		<p class="subnote">Hva går prosjektet ditt ut på?</p>
		<textarea name="desc" cols="40" rows="5" class="boxinput"><?= $project->getDescription() ?></textarea>

		<div style="margin-top: 2em;">
			<hr class="ruler">

			<input type="submit" class="btn" value="Opprett prosjekt"></a>
		</div>
	</form>
</article>

</main>