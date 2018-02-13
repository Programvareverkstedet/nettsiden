<?php
require_once dirname(__DIR__, 2) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

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

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<link rel="stylesheet" href="../css/admin.css">

<header class="admin">Stor-&shy;gutt-&shy;leketøy</header>

<main>

<article>
	<h2>Verktøy</h2>
	<?php
		if($isAdmin | $activityGroup){
			echo '<a class="btn adminbtn" href="aktiviteter/?page=1">Aktiviteter/Hendelser</a>';
		}

		if($isAdmin | $projectGroup){
			echo '<a class="btn adminbtn" href="prosjekter/">Prosjekter</a>';
		}

		if($isAdmin){
			echo '<a class="btn adminbtn" href="brukere/">Brukere</a>';
		}
	?>
</article>

</main>

<nav>
	<?= navbar(1); ?>
	<?= loginbar(null, $pdo); ?>
</nav>
