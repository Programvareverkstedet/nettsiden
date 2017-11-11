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
	0
);
if($new == 0){
	$project = $projectManager->getByID($projectID);
}
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
	<li class="active"><a href="../../prosjekt/">prosjekter</a></li>
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

<article>
	<h2><?= ($new == 1 ? "Nytt prosjekt" : "Rediger prosjekt"); ?></h2>

	<form action="update.php", method="post" class="gridsplit5050">
		<div class="gridl">
			<p class="subtitle">Tittel</p>
			<?= '<input type="text" name="title" value="' . $project->getName() . '" class="boxinput">' ?><br>

			<p class="subtitle">Beskrivelse</p>
			<textarea name="desc" cols="40" rows="5" class="boxinput"><?= $project->getDescription(); ?></textarea>
		</div>

		<div class="gridr noborder">
			<p class="subtitle">Prosjekteier (Brukernavn)</p>
			<?= '<input type="text" name="organiser" value="' . $project->getOwnerUName(). '" class="boxinput">' ?><br>

			<p class="subtitle">Prosjekteier (Navn)</p>
			<?= '<input type="text" name="organisername" value="' . $project->getOwner(). '" class="boxinput">' ?>

			<p class="subtitle">Aktiv</p>
			<?= '<input type="checkbox" '. ($project->getActive() ? 'checked' : '') . ' name="active"/>' ?>
		</div>

		<?= '<input type="hidden" name="id" value="' . $project->getID() . '" />' ?>

		<div class="allgrids" style="margin-top: 2em;">
			<hr class="ruler">

			<input type="submit" class="btn" value="Lagre"></a>
		</div>
	</form>
	<p>
</article>

</main>
