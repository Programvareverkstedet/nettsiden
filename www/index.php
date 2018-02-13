<?php
require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$translation = ['i dag', 'i morgen', 'denne uka', 'neste uke', 'denne måneden', 'neste måned'];
?>
<!DOCTYPE html>
<html lang="no">
<title>Programvareverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/splash.css">
<link rel="shortcut icon" href="favicon.ico">

<header>Program&shy;vare&shy;verk&shy;stedet</header>

<main>

<article class="threed">
	<img src="pvv-logo.png" class="float-right">
	<h2>Velkommen til Program&shy;vare&shy;verk&shy;stedet</h2>
	<p>Programvareverkstedet (PVV) vil skape et miljø for datainteresserte personer tilknyttet universitetet. Nåværende og tidligere studenter ved NTNU, samt ansatte ved NTNU og tilstøtende miljø, kan bli medlemmer. </p>
	<p>
		<a class="btn" href="om/">Om PVV</a>
		<a class="btn" href="paamelding/">Bli medlem</a>
		<a class="btn" href="https://use.mazemap.com/?v=1&amp;left=10.4032&amp;right=10.4044&amp;top=63.4178&amp;bottom=63.4172&amp;campusid=1&amp;zlevel=2&amp;sharepoitype=point&amp;sharepoi=10.40355%2C63.41755%2C2&amp;utm_medium=longurl">Veibeskrivelse</a>
	</p>
</article>

<div class="split">
<article>
<h2>Kommende arrangement</h2>
<ul class="calendar-events">
<?php $counter1 = 0; ?>
<?php $counter2 = 0; ?>
<?php foreach($agenda->getNextDays() as $period => $events) if ($events && $counter1 < 2 && $counter2 < 10) { $counter1++ ?>
<li>
<p><?= $translation[$period] ?></p>
<ul>
<?php foreach($events as $event) { $counter2++ ?>
<li>
	
<?php if ($event->getURL()) { ?>
	<a href="<?= htmlspecialchars($event->getURL()) ?>"><?= $event->getName(); ?></a>
<?php } else { ?>
	<strong><?= $event->getName(); ?></strong>
<?php } ?>
<?php /* <a class="icon subscribe">+</a> */ ?>
<?php if ($period !== \pvv\side\Agenda::TODAY) {
	echo '<span class="time">' . $event->getStart()->format('H:i') . '</span>';
	if (\pvv\side\Agenda::isThisWeek($event->getStart()) || $event->getStart()->sub(new DateInterval('P3D'))->getTimestamp() < time()) {
		echo '<span class="date">' . strftime('%a', $event->getStart()->getTimestamp()) . '</span>';
	} else {
		echo '<span class="date">' . strftime('%e. %b', $event->getStart()->getTimestamp()) . '</span>';
	}
} else {
	echo '<span class="time">' . $event->getStart()->format('H:i') . '</span>';
}
?>
</li>
<?php } ?>
</ul>
<?php } ?>
</ul>
<p><a class="btn" href="kalender/">Flere aktiviteter</a></p>
</article>
<article>
<h2>Opptak</h2>
<p>
Alle med tilknytning til NTNU kan bli medlem hos oss
og benytte seg av våre ressurser.
<!--
For å bli med i våre prosjekter og komitéer må du søke.
-->
</p>
<p>
<a class="btn" href="paamelding/">Bli medlem</a>
<!--
<a class="btn" href="prosjekt/">Søk prosjekt</a>
<a class="btn" href="prosjekt/">Søk komité</a>
-->
</p>
</article>
</div>

</main>

<nav>
	<?php echo navbar(0, ''); ?>
	<?php echo loginbar($sp, $pdo); ?>
</nav>
