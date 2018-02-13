<?php
require __DIR__ . '/../../inc/navbar.php';
require __DIR__ . '/../../src/_autoload.php';
require_once __DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';
require __DIR__ . '/../../sql_config.php';

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

$isAdmin = $userManager->isAdmin($uname);
$projectGroup = $userManager->hasGroup($uname, 'prosjekt');
$activityGroup = $userManager->hasGroup($uname, 'aktiviteter');

if(!($isAdmin | $projectGroup | $activityGroup)){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/nav.css">
	<link rel="stylesheet" href="../css/events.css">
	<link rel="stylesheet" href="../css/admin.css">
</head>

<body>
	<nav id="navbar">
		<?php echo navbar(1, 'admin'); ?>
		<?php echo loginbar(); ?>
	</nav>

	<main>
		<h2>Voksenleketøy</h2>
		<ul class="tools">
			<?php
				if($isAdmin | $activityGroup){
					echo '<li><a class="btn" href="aktiviteter/?page=1">Aktiviteter/Hendelser</a></li>';
				}

				if($isAdmin | $projectGroup){
					echo '<li><a class="btn" href="prosjekter/">Prosjekter</a></li>';
				}

				if($isAdmin) {
					echo '<li><a class="btn" href="motd/">Dagens melding</a></li>';
				}

				if($isAdmin){
					echo '<li><a class="btn" href="brukere/">Brukere</a></li>';
				}
			?>
		<ul>
	</main>
</body>