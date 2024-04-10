<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
error_reporting(E_ALL);
require __DIR__ . '/../../../inc/navbar.php';
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../config.php';
require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
$attrs = $as->getAttributes();

$pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if(!$userManager->isAdmin($uname)){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}

$motdfetcher = new \pvv\side\MOTD($pdo);
$motd = $motdfetcher->getMOTD();
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/nav.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">
<meta name="theme-color" content="#024" />
<title>MOTDadministrasjonsverkstedet</title>

<header>MOTD&shy;administrasjons&shy;verk&shy;stedet</header>

<body>
	<nav>
		<?php echo navbar(2, 'admin'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Dagens melding</h2>
		<hr class="ruler">

		<form action="update.php", method="post">
			<p class="subtitle no-chin">Tittel</p>
			<p class="subnote">Ikke nødvendig</p>
			<input type="text" name="title" value="<?= $motd['title'] ?>" class="boxinput" style="width:66%;"><br>

			<p class="subtitle no-chin">Innhold (<i>markdown</i>)</p>
			<textarea name="content" style="width:100%" rows="8" class="boxinput"><?= implode("\n", $motd["content"]) ?></textarea>

			<div style="margin-top: 2em;">
				<hr class="ruler">

				<?= '<input type="submit" class="btn" value="Lagre endringer"></a>'; ?>
			</div>
		</form>
	</main>
</body>
