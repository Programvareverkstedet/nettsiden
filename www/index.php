<?php require '../src/_autoload.php'; date_default_timezone_set('Europe/Oslo') ?><!DOCTYPE html>
<title>Programvareverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/splash.css">

<nav>
	<li class="active"><a href="index.php">hjem</a></li>
	<li><a href="kurs/index.html">kurs</a></li>
	<li><a href="prosjekt/index.html">prosjekt</a></li>
	<li><a href="sosiale/index.html">sosiale</a></li>
	<li><a href="pvv/">wiki</a></li>
</nav>

<header>Program&shy;vare&shy;verk&shy;stedet</header>

<ul id="ticker">
	<li>I DAG: <a href="">nerdepitsa</a>
</ul>

<main>

<article class="threed">
	<img src="pvv-logo.png" class="float-right">
	<h2>Velkommen til Program&shy;vare&shy;verk&shy;stedet</h2>
	<p>Programvareverkstedet (PVV) vil skape et miljø for datainteresserte personer tilknyttet universitetet. Nåværende og tidligere studenter ved NTNU, samt ansatte ved NTNU og tilstøtende miljø, kan bli medlemmer. </p>
	<p>
		<a class="btn" href="paamelding/index.html">Bli medlem</a>
		<a class="btn" href="https://use.mazemap.com/?v=1&amp;left=10.4032&amp;right=10.4044&amp;top=63.4178&amp;bottom=63.4172&amp;campusid=1&amp;zlevel=2&amp;sharepoitype=point&amp;sharepoi=10.40355%2C63.41755%2C2&amp;utm_medium=longurl">Veibeskrivelse</a>
	</p>
</article>

<div class="split">
<article>
<h2>Kommende arrangement</h2>
<ul class="calendar-events">
<?php $translation = ['i dag', 'i morgen', 'denne uka', 'denne måned', 'neste måned'] ?>
<?php $counter1 = 0; ?>
<?php $counter2 = 0; ?>
<?php foreach((new \pvv\side\Agenda())->getNextDays() as $period => $events) if ($events && $counter1 < 2 && $counter2 < 10) { $counter1++ ?>
<li><p><?= $translation[$period] ?> <span><?= reset($events)->getStart()->format('Y-m-d'); ?></span></p>
<ul>
<?php foreach($events as $event) { $counter2++ ?>
<li>
<a><?= $event->getName(); ?></a>
<span><?= $event->getStart()->format('H:i'); ?></span>
<a class="icon subscribe" href="">+</a>
</li>
<?php } ?>
</ul>
<?php } ?>
</ul>
<p><a class="btn" href="kalender/index.html">Flere aktiviteter</a></p>
</article>
<article>
<h2>Opptak</h2>
<p>
Alle med tilknytning til NTNU kan bli medlem hos oss
og benytte seg av våre ressurser.
For å bli med i våre prosjekter og komitéer må du søke.
</p>
<p>
<a class="btn" href="paamelding/index.html">Bli medlem</a>
<a class="btn" href="soek/index.html">Søk prosjekt</a>
<a class="btn" href="soek/index.html">Søk komité</a>
</p>
</article>
</div>

</main>
