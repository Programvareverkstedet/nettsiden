<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

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
	header('Content-Type: text/plain', true, 403);
	echo "Her har du ikke lov't'å'værra!!!\r\n";
	exit();
}
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/events.css">
	<link rel="stylesheet" href="../css/admin.css">
</head>

<body>
	<nav id="navbar">
		<?php echo navbar(1, 'admin'); ?>
		<?php echo loginbar(null, $pdo); ?>
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
