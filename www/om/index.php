<?php 
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
?>
<!DOCTYPE html>
<html lang=no>
<style>
p {hyphens: auto;}
</style>
<title>Programvareverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">

<header>Programvareverkstedet</header>

<main>

<article>
	<h2>Om Programvareverkstedet</h2>

	<p>Velkommen til Programvareverkstedets nettside. Programvareverkstedet (PVV) er en studentorganisasjon ved Norges Teknisk-Naturvitenskapelige Universitet (NTNU). PVVs formål er å skape et miljø for datainteresserte personer tilknyttet universitetet. Nåværende og tidligere studenter ved NTNU, samt ansatte ved NTNU og tilstøtende miljø, kan bli medlemmer.</p>
</article>

<article>
	<h2>Hva betyr det å være et medlem av PVV?</h2>

	<p>Alle medlemmer av PVV får brukerkonto på PVV sine maskiner, epostadresse (<code lang="">brukernavn@pvv.ntnu.no</code> og <code lang="">brukernavn@pvv.org</code>) og 757 MB diskplass, som blant annet kan brukes til hjemmesider. Dersom du går tom for diskplass er det mulig å kjøpe utvidet diskkvote. For å aktivere brukerkonto på PVV, må man møte opp på lokalene slik at man får satt passord.

	<p>I tillegg får man tilgang til PVVs to oppholdsrom, rom 226 og 229 i Sentralbygg 2 (se kart over andre etasje i SBII). På rom 229 er det seks arbeidsstasjoner som kjører Linux, macOS, FreeBSD, samt bordplass, nettverksuttak og egen Wifi AP for laptoper. På rom 226 er det sofakrok med TV og diverse spillkonsoller.

	<p>Dersom du ønsker å lære Unix er det god anledning til det på PVV. Vi har et sterkt faglig miljø, med mange svært kunnskapsrike personer, som stort sett ikke har noe imot å hjelpe nybegynnere. Man kan få større privilegier her enn på stud-maskinene, for eksempel gjennom å bli med i PVV-drift.

	<p>PVV har gratis kaffe for medlemmer. Vi organiserer kurs og andre arrangementer. De aller fleste arrangementene er gratis.

	<p>PVV har også ei relativt innholdsrik boksamling til disposisjon for medlemmene, samt ei bokhylle full av blad og tegneserier. (For tiden abonnerer vi på Lunch tegneserie). Vi har i tillegg et romslig bokbudsjett, så dersom du har forslag til bøker/blad vi burde kjøpe inn er det bare å sende en mail til styret (<code lang="">pvv@pvv.ntnu.no</code>). Ta en titt på hva som står i bokhyllen.

	<p>PVV har også en del brettspill du kan prøve. 
</article>

<article>
	<h2>Hvordan bli medlem</h2>

	<p>Første steg for å bli medlem i PVV er å betale medlemskontingent.

	<p>Medlemskontingenten er kr 50,00 per år. Det er også mulig å bli livstidsmedlem ved å betale kr 1024,00 én gang. Kontingent betales til konto <code lang="">8601.11.16916</code>. Betalingen Må merkes med NTNU brukernavn.

	<p>Det er mulig å betale for flere år samtidig ved å betale et helt multiplum av kr 50.

	<p>Kontingentinnbetalinger blir registrert i medlemsdatabasen, og det er lurt å sjekke at betalingen din dukker opp her (merk at det kan ta litt tid fra du betaler til kasserer får beskjed om det, og deretter litt tid før kasserer fører betalingen inn i regnskap og medlemsdatabase).

	<p>
		<a class="btn" href="../paamelding/">Registrer deg som bruker</a>
	</p>
</article>

</main>

<nav>
	<?= navbar(1); ?>
	<?= loginbar($sp, $pdo); ?>
</nav>
