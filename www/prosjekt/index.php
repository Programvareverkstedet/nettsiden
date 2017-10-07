<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';
$translation = ['i dag', 'i morgen', 'denne uka', 'neste uke', 'denne måneden', 'neste måned'];
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$agenda = new \pvv\side\Agenda([
		new \pvv\side\social\NerdepitsaActivity,
		new \pvv\side\social\AnimekveldActivity,
		new \pvv\side\social\BrettspillActivity,
		new \pvv\side\DBActivity($pdo),
	]); ?>
<!DOCTYPE html>
<html lang="no">
<title>Prosjektverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/splash.css">

<header>Prosjekt&shy;verk&shy;stedet</header>

<?php 
include '../../inc/ticker.php';
?>

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
<p>
	Lyst til å gjøre noe kult? Her er de prosjektene som PVVere er ivrige i å gjøre. Mangler det noe, eller brenner du for noe annet? Sett opp et prosjekt da!<br>
	<br>
	<a class="btn" href="/aktiviteter/lag">Lag prosjekt</a>
</p>
<ul class="calendar-events">
<li><p><a href="project.html?id=1">Fikse Brzeczyszczykiewicz</a></p>
<span><p>
	Skjermen på bokhyllen vår, Brzeczyszczykiewicz, sluttet å virke etter noen oppdateringer. Denne vil jeg gjerne fikse sammen med en gjeng.
</p></span>
</li>

<li><p><a href="project.html?id=2">Lage hjemmeside</a></p>
<span><p>
	PVV trenger en fin hjemmeside! Hadde vært kult om noen ville være med meg å ordne denne.
</p></span>
</li>

<li><p><a href="project.html?id=3">Spis Peder</a></p>
<span><p>
	Jeg er ensom...
</p></span>
</li>
</article>


<article>
<h2>Komitéer</h2>
<p>
	De er deilige
</p>
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
	Styret bestemmer hvilke kurs, hackehelger og innkjøp som skal fåretaes. Er det noen som kan få ordnet opp i noe er det Styret. Intressert? Vi velger styret på halvårsmøtene på starten av semestrene. Kom og bli med da vel! 
</p></span>
</li>
</ul>
</article>
</div>

</main>

<nav><ul>
	<li><a href="../">hjem</a></li>
	<li class="active"><a href="../prosjekt/">prosjekter</a></li>
	<li><a href="../aktiviteter/">aktiviteter</a></li>
	<li><a href="../kontakt">kontakt</a></li>
	<li><a href="../pvv/">wiki</a></li>
</nav>
