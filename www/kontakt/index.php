<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<meta name="theme-color" content="#024" />
<title>Kommunikasjonsverkstedet</title>

<header>Kommunikasjons&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(1, 'kontakt'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Kommunikasjon<br><img style="width: 8em" src="kontakt.jpg"></img></h2>

		<p> Det er flere ulike måter å kommunisere med PVV og deres medlemmer på.

		<p> Du kan registrere deg på våre <a href="http://list.pvv.org/mailman/listinfo/aktive">Aktive epostlister</a> for å få informasjon om de kommende aktivitetene våre.

		<p> Kontaktinformasjonen til Styret og Drift funner du på vår <a href="../pvv/Kontaktinformasjon">Wiki</a>

		<p> Vi har en IRC-kanal på <a href="http://webchat.ircnet.net/">IRCnet</a> kalt #pvv.

		<p> Vi har også en Discord-kanal. Denne kanalen er satt opp slik at man i Discord-kanalen ser hva som skrives i IRC-kanalen, og vice versa. For å bli med i Discord-kanalen, <a href="https://discord.gg/8VTBr6Q">klikk her</a>.
			<i>(Denne broen for øyeblikket ute av drift)</i>

		<p> Det er også mulig å ta i bruk analog kontakt ved å møte opp <a href="https://use.mazemap.com/?v=1&left=10.4032&right=10.4044&top=63.4178&bottom=63.4172&campusid=1&zlevel=2&sharepoitype=point&sharepoi=10.40355%2C63.41755%2C2&utm_medium=longurl">på stripa</a>.

	</main>
</body>
