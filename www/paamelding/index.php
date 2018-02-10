<?php
require_once __DIR__ . '/../../inc/navbar.php';
require_once __DIR__ . '/../../lib/OAuth2-Client/OAuth2Client.php';
require_once __DIR__ . '/../../dataporten_config.php';
require_once __DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';
session_start();

$as = new SimpleSAML_Auth_Simple('default-sp');
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
	$token = $oauth2 -> get_access_token();
	$_SESSION['userdata'] = $oauth2 -> get_identity($token, 'https://auth.dataporten.no/userinfo');
	
	header('Location: ' . $dataportenConfig["redirect_uri"]);
	die();
}

if (isset($_SESSION['userdata'])) { // if logged in with feide
	$mailBody
		= "Hei, jeg vil bli medlem på PVV.\n"
		. "Navn: " . htmlspecialchars($_SESSION['userdata']['user']['name']) . "\n"
		. "Brukernavn: " . htmlspecialchars($_SESSION['userdata']['user']['userid_sec'][0]) . "\n"
		. "Epost: " . htmlspecialchars($_SESSION['userdata']['user']['email']) . "\n";
}

?>
<!DOCTYPE html>

<head>
	<title>PVV registrering</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/nav.css">
</head>

<body>
	<nav>
		<?php echo navbar(1); ?>
		<?php echo loginbar(); ?>
	</nav>

	<main>
		<h2>Registrer deg som bruker</h2>
		
		<p>
			PVV har for øyeblikket et manuelt system for å legge til nye brukere.
			Vi foretrekker at du kommer inn på besøk på <a href="https://use.mazemap.com/?v=1&left=10.4032&right=10.4044&top=63.4178&bottom=63.4172&campusid=1&zlevel=2&sharepoitype=point&sharepoi=10.40355%2C63.41755%2C2&utm_medium=longurl">våre lokaler på stripa</a>
			for å sette sette opp din PVV bruker. Hvis du vil, kan du også sende oss
			en melding fra denne siden med ditt navn, epost og NTNU brukernavn.
			For å aktivere din brukerkonto på PVV, må du møte opp på
			lokalene våre slik at vi kan få satt et passord.
		</p>
		
		<h3>Meldingen du kan sende:</h3>
		
		
		<?php if($attrs) { //logged in with pvv account?>
			<p>
				Du er logget in som <i><?= htmlspecialchars($attrs['uid'][0]) ?></i>,
				du trenger ikke sende melding om ny bruker fordi du helt klart har en.
			</p>
		<?php } elseif (isset($_SESSION['userdata'])) { //logged in with feide ?>
			<code>
				Til: drift@pvv.ntnu.no<br>
				Fra: nettsiden<br>
				<br/>
				<?= nl2br($mailBody) ?>
			</code><br>
			<br>
			Todo: Legg til en "send mail" knapp
		<?php } else { // not logged in?>
			<a class="btn" href=".?login">æ kanj itj lææv uten dæ piær!</a>
		<?php }?>
			
	</main>
</body>
