<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
error_reporting(E_ALL);
require __DIR__ . '/../../../inc/navbar.php';
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';
require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$attrs = $as->getAttributes();

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
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

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../../css/normalize.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="../../css/nav.css">
	<link rel="stylesheet" href="../../css/events.css">
	<link rel="stylesheet" href="../../css/admin.css">
</head>

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

			<p class="subtitle no-chin">Innhold</p>
			<textarea name="content" style="width:100%" rows="8" class="boxinput"><?= implode($motd["content"], "\n") ?></textarea>

			<div style="margin-top: 2em;">
				<hr class="ruler">

				<?= '<input type="submit" class="btn" value="Lagre endringer"></a>'; ?>
			</div>
		</form>
	</main>
</body>