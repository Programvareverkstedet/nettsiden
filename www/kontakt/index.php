<!DOCTYPE html>
<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../inc/navbar.php';
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';
?>
<html lang="no">
<title>Kommunikasjonsverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">

<header>Kommunikasjons&shy;verk&shy;stedet</header>

<main>

<article>

<h2>Kommunikasjon</h2>
<p>
Det er ulike måter å kommunisere med PVV-medlemmer på.
</p>
<p>
Vi har en IRC-kanal på <a href="http://webchat.ircnet.net/">IRCnet</a> kalt #pvv.
</p>
<p>
Vi har også en Discord-kanal. Denne kanalen er satt opp slik at man i Discord-kanalen ser hva som skrives i IRC-kanalen, og vice versa. For å bli med i Discord-kanalen, <a href="https://discord.gg/8VTBr6Q">klikk her</a>.
</p>
<p>
Det er også mulig å ta i bruk analog kontakt ved å møte opp <a href="https://use.mazemap.com/?v=1&left=10.4032&right=10.4044&top=63.4178&bottom=63.4172&campusid=1&zlevel=2&sharepoitype=point&sharepoi=10.40355%2C63.41755%2C2&utm_medium=longurl">på stripa</a>.
</p>
</article>

</main>

<nav>
	<?= navbar(1, 'kontakt'); ?>
	<?= loginbar(); ?>
</nav>
