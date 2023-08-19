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
<meta name="theme-color" content="#024" >
<title>Kommunikasjonsverkstedet</title>

<header>Kommunikasjons&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(1, 'kontakt'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>
			Kontaktinformasjon
			<a href="https://en.wikipedia.org/wiki/IP_over_Avian_Carriers">
				<img style="width: 8em" src="kontakt.jpg">
			</a>
		</h2>

		<p>
			Vi kan kontaktes på følgende e-postadresser:
			<ul>
				<li><a href="mailto:pvv@pvv.ntnu.no">pvv@pvv.ntnu.no</a> for hendvendelser til styret</li>
				<li><a href="mailto:drift@pvv.ntnu.no">drift@pvv.ntnu.no</a> for hendvendelser anngående våre datasystemer</li>
			</ul>
		</p>

		<p>Det er også mulig å ta kontakt med oss ved å møte opp <a href="https://link.mazemap.com/JqgWGSnh">på våre lokaler i oppredning/gruvedrift</a>.</p>

		<h2>Kommunikasjonskanaler</h2>

		<p>Vi har en <a href="http://list.pvv.org/mailman/listinfo/aktive">e-postliste for aktive medlemmer</a>. All offisiell informasjon blir sendt på denne listen, og alle arrengementer blir også annonsert her.</p>

		<p>Vi har en <a target="_blank" href="https://matrix.to/#/#pvv:pvv.ntnu.no">Matrix-server</a> for chat, memes, og all annen kommunikasjon. Den er bridget med IRC-kanalen og Discord-guilden vår. Hvis du er medlem kan du bruke vår <a href="https://chat.pvv.ntnu.no">self-hosted web client</a>.</p>
		
		<p>Vi har en IRC-kanal på <a href="http://webchat.ircnet.net/">IRCnet</a> kalt #pvv.</p>

		<p>Vi har en <a target="_blank" href="https://discord.gg/8VTBr6Q">Discord-guild</a> for de som foretrekker Discord over Matrix. </p>

	</main>
</body>
