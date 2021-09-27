<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

session_start();

$attrs = $as->getAttributes();

$oauth2 = new Kasperrt\Oauth2($dataportenConfig);

if (isset($_GET['logout'])) {
	session_destroy();
	header('Location: ' . $dataportenConfig["redirect_uri"]);
	die();
}
if (isset($_GET['login'])) {
	$oauth2 -> redirect();
	die();
}
if (isset($_GET['code'])) {
	$token = $oauth2 -> get_access_token(htmlspecialchars($_GET['state']), htmlspecialchars($_GET['code']));
	$_SESSION['userdata'] = $oauth2 -> get_identity($token, 'https://auth.dataporten.no/userinfo');
	
	header('Location: ' . $dataportenConfig["redirect_uri"]);
	die();
}

?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/nav.css">
<meta name="theme-color" content="#024" />
<title>Registreringsverkstedet</title>

<header>Registrerings&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(1); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Å bli medlem på PVV</h2>
		
		<p>
			Første steg for å bli medlem i PVV er å betale
			<a href="../pvv/Medlemskontingent">medlemskontingent</a> på 50kr per år.
			Disse pengene brukes for å drifte PVV. Se lenken for kontonummeret.
		</p>
		<p>
			Alle medlemmer av PVV får brukerkonto på PVV sine maskiner, epostadresse
			(brukernavn@pvv.ntnu.no og brukernavn@pvv.org) og 757 MB diskplass, som
			blant annet kan brukes til hjemmesider. Dersom du går tom for diskplass
			er det mulig å kjøpe utvidet diskkvote. For å aktivere brukerkonto på PVV,
			å man møte opp på lokalene slik at man får satt passord.
		</p>
		<p>
			Mer informasjon om medlemskap finner du <a href="../pvv/Medlem">her</a>.
		</p>
		
		<h2>Registrer deg som bruker</h2>
		
		<p>
			PVV har for øyeblikket et manuelt system for å legge til nye brukere.
			Se lenkene over for mer informasjon.
			Vi foretrekker at du kommer inn på besøk på <a href="https://link.mazemap.com/aKDz8eu8">våre lokaler i Oppredning/Gruvedrift, rom 247</a>
			for å sette sette opp din PVV bruker. Hvis du ikke har mulighet til det, kan du <a href="../pvv/Kontaktinformasjon">finne oss her</a> og sende en epost.
			For å aktivere din brukerkonto på PVV, må du alikevell møte opp på
			lokalene våre slik at vi kan få satt ditt passord.
		</p>
		<iframe width="600" height="420" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://use.mazemap.com/embed.html#v=1&zlevel=2&center=10.406194,63.417143&zoom=18&campusid=1&sharepoitype=poi&sharepoi=38159&utm_medium=iframe" style="border: 1px solid grey" allow="geolocation"></iframe><br/>
	
		<?php if($attrs) { //logged in with pvv account?>
			<p>
				Du er nå logget in som <i><?= htmlspecialchars($attrs['uid'][0]) ?></i>,
				og trenger klart ikke sende melding om å få ny PVV bruker.
			</p>
		<?php } ?>
	</main>
</body>
