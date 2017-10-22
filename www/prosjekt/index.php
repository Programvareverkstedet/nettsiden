<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
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
<link rel="stylesheet" href="../css/splash.css">

<header>Prosjekt&shy;verk&shy;stedet</header>

<main>

<article class="threed">
	<img src="favicon-search-light.svg" width=140 style="margin: 20px;" class="float-right">
	<h2>Søk projekt eller komité</h2>
	<p>Ønsker du å bli med på en komité eller et projekt? Søk her da vel!</p>
	<!--
	<p>
		<a class="btn" href="/paamelding/">Bli medlem</a>
		<a class="btn" href="/rom/">Veibeskrivelse</a>
	</p>
	-->
</article>
<div class="split">

<article>
<h2>Projekter</h2>
<?php
	if(count($projects) == 0){
?>
	<p>PVV har for øyeblikket ingen aktive prosjekter. Tenker du at noe bør gjøres? Har du en kul ide for noe PVV kan samarbeide om? Sett opp et prosjekt!</p>
	<br>
	<a class="btn" href="ny.php">Lag prosjekt</a>
<?php
	}else{
?>
	<p>Lyst til å gjøre noe kult? Her er et utvalg av de prosjektene som PVVere har laget. Mangler det noe, eller brenner du for noe annet? Sett opp et prosjekt!</p>
	<br>
	<a class="btn" href="ny.php">Lag prosjekt</a>

	<ul class="calendar-events">
		<?php
			$randProjects = array_rand($projects, min(3, count($projects)));

			for($i = 0; $i < count($randProjects); $i++){
				$project = $projects[$randProjects[$i]];
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


<article>
<h2>Komitéer</h2>
<ul class="calendar-events">

<li><p><a href="trikom.html">Trikom</a></p>
<span><p>
	Trikom er trivselskomitéen til PVV. Trikoms ønske er å holde trivselen på PVV på topp! Vi har ansvaret for å holde PVV åpent og ryddig. 
</p></span>
</li>

<li><p><a href="PR.html">PR</a></p>
<span><p>
	PR jobber med å reklamere for PVVs kurs, arrangementer og andre diverse foretak. Spesiell stor innsats ønskes rundt immatrikuleringen. Vi styrer PVVs Facebookside, og sender meldinger ut på mailingslistene. Tror du dette er noe for deg, så søk da vel! :)
</p></span>
</li>

<li><p><a href="drift.html">Drift</a></p>
<span><p>
	Drift holder maskinene og serverene på PVV i god stand. Vi drifter også nettsidene, brukersystemene og mye mye mer. Er du intressert i eller vil lære om servere og infrastruktur er dette tingen for deg! Alle i drift har full tilgang til systemene til PVV.
</p></span>
</li>

<li><p><a href="styret.html">Styret</a></p>
<span><p>
	Styret bestemmer hvilke kurs, hackehelger og innkjøp som skal foretas. Er det noen som kan få ordnet opp i noe er det Styret. Intressert? Vi velger styret på halvårsmøtene på starten av semestrene. Kom og bli med da vel! 
</p></span>
</li>
</ul>
</article>
</div>

</main>

<nav><ul>
	<li><a href="../">hjem</a></li>
	<li><a href="../kalender/">kalender</a></li>
	<li><a href="../aktiviteter/">aktiviteter</a></li>
	<li class="active"><a href="../prosjekt/">prosjekter</a></li>
	<li><a href="../kontakt/">kontakt</a></li>
	<li><a href="../pvv/">wiki</a></li>
</nav>