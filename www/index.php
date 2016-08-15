<?php require '../src/_autoload.php'; ?><!DOCTYPE html>
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



<?php
/* include "../../nettsiden/src/_autoload.php"; */
/* use \pvv\side\Events; */
# TEST START
#Class Event {
#    private $start, $name;
#    function Event($name,$start){$this->start = $start;$this->name=$name;}
#    function getName(){return $this->name;}
#    function getStart(){return $this->start;}
#}
/* $evs = new Events(); */
/* $events = $evs->getAllEvents(); */
/* # TEST END */
/* 		<a href="">animekveld</a> */

/* echo "<li><p>i dag<span>".date("Y-m-d")."</span></p>"; */
/*     echo "<ul>"; */
/* foreach($events as $ev){ */
/*     echo "<li>"; */
/*     echo "<a href=\"\">".$ev->getName()."</a>"; */
/*     echo "<span>".$ev->getStart()."</span>"; */
/*     echo "		<a class=\"icon subscribe\" href=\"\">+</a>"; */
/*     echo "	</li>"; */
/* } */
?>

<?php 
$a = new \pvv\side\social\NerdepitsaActivity;
$nextPizzaDate = $a->nextDate(new \DateTimeImmutable);
$a = new \pvv\side\social\AnimekveldActivity;
$nextAnimeDate = $a->nextDate(new \DateTimeImmutable);
?>

<li><p><?=$nextPizzaDate->format('l')?><span><?=$nextPizzaDate->format('Y-m-d')?></span></p>
<ul>
	<li>
        <a href="nerdepitsa/index.html">nerdepitsa</a>
        <span><?=$nextPizzaDate->format('H.i')?></span>
		<a class="icon subscribe" href="">+</a>
	</li>
	<li>
    	<a href="animekveld/index.html">animekveld</a>
        <span><?=$nextAnimeDate->format('H.i')?></span>
		<a class="icon subscribe" href="">+</a>
	</li>
</ul>
</li>

<li><p>noen gang<span>2016-08-XX</span></p>
<ul>
	<li>
		<a href="">styremøte</a>
		<span>XX.00</span>
		<a class="icon subscribe" href="">+</a>
	</li>
</ul>
</li>



</ul>
<p><a class="btn" href="kalender/index.html">Flere aktiviteter</a></p>
</article>
<article>
<h2>Opptak</h2>
<p>
Alle med tilknytning til NTNU kan bli medlem hos oss
og benytte seg av våre ressurs.
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
