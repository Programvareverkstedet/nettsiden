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
	1
);
if($new == 0){
	$project = $projectManager->getByID($projectID);

	if($project->getOwnerUName() != $attrs["uid"][0]){
		header('HTTP/1.0 403 Forbidden');
		echo "wrong user";
		exit();
	}
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">

<nav>
	<ul>
	<li><a href="../index.php">hjem</a></li>
	<li><a href="../kalender/">kalender</a></li>
	<li><a href="../aktiviteter/">aktiviteter</a></li>
	<li class="active"><a href="../prosjekt/">prosjekter</a></li>
	<li><a href="../kontakt/">kontakt</a></li>
	<li><a href="../pvv/">wiki</a></li>
	</ul>

	<?php
		if($attrs){
			$uname = $attrs["uid"][0];
			echo '<p class="login">logget inn som: ' . $uname . '</p>';
		}else{
			echo '<a class="login" href="' . $as->getLoginURL() . '">logg inn</a>';
		}
	?>
</nav>


<header>Prosjekt&shy;verk&shy;stedet</header>

<main>

<article>
	<h2>Nytt prosjekt</h2>

	<form action="update.php", method="post">
		<p class="subtitle no-chin">Prosjektnavn</p>
		<p class="subnote">Gi prosjektet ditt et passende navn</p>
		<input type="text" name="title" value="<?= $project->getName() ?>" class="boxinput" style="width:66%;"><br>

		<p class="subtitle no-chin">Beskrivelse</p>
		<p class="subnote">Hva går prosjektet ditt ut på?</p>
		<textarea name="desc" style="width:100%" rows="8" class="boxinput"><?= $project->getDescription() ?></textarea>

		<?= '<input type="hidden" name="id" value="' . $project->getID() . '" />' ?>

		<div style="margin-top: 2em;">
			<hr class="ruler">

			<?= '<input type="submit" class="btn" value="' . ($new ? 'Opprett prosjekt' : 'Lagre endringer') . '"></a>'; ?>
		</div>
	</form>
</article>

</main>
