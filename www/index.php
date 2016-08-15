<!DOCTYPE html>
<title>Programvareverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/splash.css">

<nav>
	<li class="active"><a href="index.html">hjem</a></li>
	<li><a href="kurs/index.html">kurs</a></li>
	<li><a href="prosjekt/index.html">prosjekt</a></li>
	<li><a href="sosiale/index.html">sosiale</a></li>
	<li><a href="wiki/index.html">wiki</a></li>
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
		<a class="btn" href="rom/index.html">Veibeskrivelse</a>
	</p>
</article>

<div class="split">
<article>
<h2>Kommende arrangement</h2>
<ul class="calendar-events">
<?php
include "../../nettsiden/src/_autoload.php";
use \pvv\side\Events;
# TEST START
#Class Event {
#    private $start, $name;
#    function Event($name,$start){$this->start = $start;$this->name=$name;}
#    function getName(){return $this->name;}
#    function getStart(){return $this->start;}
#}
$evs = new Events();
$events = $evs->getAllEvents();
# TEST END

echo "<li><p>i dag<span>".date("Y-m-d")."</span></p>";
    echo "<ul>";
foreach($events as $ev){
    echo "<li>";
    echo "<a href=\"\">".$ev->getName()."</a>";
    echo "<span>".$ev->getStart()."</span>";
    echo "		<a class=\"icon subscribe\" href=\"\">+</a>";
    echo "	</li>";
}
#echo "	<li>";
#echo "		<a href=\"\">animekveld</a>";
#echo "		<span>19.30</span>";
#echo "		<a class=\"icon subscribe\" href=\"\">+</a>";
#echo "	</li>";
echo "</ul>";
echo "</li>";
echo "<li><p>noen gang<span>2016-08-XX</span></p>";
echo "<ul>";
echo "	<li>";
echo "		<a href=\"\">styremøte</a>";
echo "		<span>XX.00</span>";
echo "		<a class=\"icon subscribe\" href=\"\">+</a>";
echo "	</li>";
echo "</ul>";
echo "</li>";
?>
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
