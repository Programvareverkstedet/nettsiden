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

if (isset($_SESSION['userdata'])) { // if logged in with feide
	$mailHeaders  = "MIME-Version: 1.0" . "\r\n";
	$mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$mailHeaders .= 'From: <spikkjeposche@pvv.ntnu.no>' . "\r\n";
	$mailHeaders .= 'Cc: <' . htmlspecialchars($_SESSION['userdata']['user']['email']) .'>' . "\r\n";
	$mailParams   = "-fspikkjeposche@pvv.ntnu.no";
	$mailTo       = "nybruker@pvv.ntnu.no";
	$mailSubject  = "Nytt medlem for PVV";
	$mailBody
		= "Hei, jeg vil bli medlem på PVV.\n"
		. "Navn: " . htmlspecialchars($_SESSION['userdata']['user']['name']) . "\n"
		. "Brukernavn: " . htmlspecialchars($_SESSION['userdata']['user']['userid_sec'][0]) . "\n"
		. "Epost: " . htmlspecialchars($_SESSION['userdata']['user']['email']) . "\n"
		. "Jeg skal betale medlemsavgiften, og kommer innom PVVs lokaler for å aktivere kontoen min";
	if (isset($_GET['send_mail'])) { // if logged in with feide
		mail($mailTo, $mailSubject, $mailBody, $mailHeaders, $mailParams);
	}
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
	
		<?php if($attrs) { //logged in with pvv account?>
			<p>
				Du er nå logget in som <i><?= htmlspecialchars($attrs['uid'][0]) ?></i>,
				og trenger klart ikke sende melding om å få ny PVV bruker.
			</p>
		<?php } elseif (isset($_SESSION['userdata'])) { //logged in with feide ?>
			<?php if (! isset($_GET['send_mail'])) { ?>
				<h3>Meldingen som du nå sender:</h3>
				<code>
					Til: <?=$mailTo?><br>
					Fra: nettsiden<br>
					Tittel: <?=$mailSubject?><br>
					<br/>
					<?= nl2br($mailBody) ?>
				</code><br>
				<br>
				<a class="btn" href=".?send_mail#sent">Send!</a>
			<?php } else { // not logged in?>
				<p id="sent">
					Meldingen har blitt sendt!
				</p>
			<?php }?>
		<?php } else { // not logged in?>
			<a class="btn" href=".?login">Hent navn og epost fra Feide</a>
		<?php }?>
		
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
