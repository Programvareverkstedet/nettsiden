<!DOCTYPE html>
<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';
?>
<html lang="no">
<title>Sosialverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">

<nav>
	<li><a href="../index.php">hjem</a></li>
	<li><a href="../kurs/index.html">kurs</a></li>
	<li><a href="../prosjekt/index.html">prosjekt</a></li>
	<li class="active"><a href="../sosiale/index.html">sosiale</a></li>
	<li><a href="../wiki/index.html">wiki</a></li>
</nav>

<header>Sosial&shy;verk&shy;stedet</header>

<main>

<?php
$activity = new \pvv\side\social\NerdepitsaActivity;
$nextEvent = $activity->getNextEventFrom(new DateTimeImmutable);
?>

<article>


	<h2><img src="../sosiale/nerdepitsa.jpg"><em><?= $nextEvent->getRelativeDate()?></em> Nerdepitsa</h2>
	<ul class="subtext">
        <li>Tid:
        <strong>
            <?= $nextEvent->getStart()->format('Y-m-d H:i');?>
        </strong>
		<li>Sted:
        <strong>
            <?= $nextEvent->getLocation();?>
        </strong>
		<li>Arrangør:
        <strong>
            <?= $nextEvent->getOrganiser();?>
        </strong>
	</ul>
	<p>Hei, har du lyst til å bli med på pizzaspising på Peppes i Kjøpmannsgata annenhver fredag klokken 19.00?

	<p>Vi er en gjeng hvis eneste gjennomgående fellestrekk er en viss interesse for data, samt at vi har eller har hatt en tilknytning til studentmiljøet ved NTNU. For å treffe andre som også faller inn under disse kriteriene treffes vi over pizza på Peppes annenhver fredag. (Definisjon: En fredag er annenhver dersom den ligger i en partallsuke). Vi har reservasjon under navnet Christensen.

	<p>Det er ikke noe krav at du er nerd ... noen av oss virker faktisk nesten normale. Det er heller ikke noe krav at du kjenner noen fra før. Det er ikke engang et krav at du må like pizza (selv om det hjelper). Dersom du har lyst til å treffe personer fra datamiljøet ved NTNU så still opp, vi biter ikke (vel, bortsett fra i pizzaen da ...)

	<p>Strategien er at vi bestiller så mye pizza som vi i fellesskap klarer å stappe ned, for deretter splitte pizza-regningen broderlig; mens hver enkelt betaler for sin egen drikke, dessert mm. 

	<p><a class="btn" href="#">Påminn meg</a>
</article>

</main>
