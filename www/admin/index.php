<?php
require_once dirname(__DIR__, 2) . implode(\DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new pvv\admin\UserManager($pdo);

$as = new SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

$isAdmin = $userManager->isAdmin($uname);
$projectGroup = $userManager->hasGroup($uname, 'prosjekt');
$activityGroup = $userManager->hasGroup($uname, 'aktiviteter');

if (!($isAdmin | $projectGroup | $activityGroup)) {
  header('Content-Type: text/plain', true, 403);
  echo "Her har du ikke lov't'å'værra!!!\r\n";
  exit;
}
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<link rel="stylesheet" href="../css/admin.css">
<meta name="theme-color" content="#024" />
<title>Administrasjonsverkstedet</title>

<header>Administrasjons&shy;verk&shy;stedet</header>


<body>
	<nav id="navbar">
		<?php echo navbar(1, 'admin'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Administrasjon</h2>
		<ul class="tools">
			<?php
        if ($isAdmin | $activityGroup) {
          echo '<li><a class="btn" href="aktiviteter/?page=1">Aktiviteter/Hendelser</a></li>';
        }

        if ($isAdmin | $projectGroup) {
          echo '<li><a class="btn" href="prosjekter/">Prosjekter</a></li>';
        }

        if ($isAdmin) {
          echo '<li><a class="btn" href="motd/">Dagens melding</a></li>';
        }

        if ($isAdmin) {
          echo '<li><a class="btn" href="brukere/">Brukerrettigheter</a></li>';
        }
      ?>
		<ul>
	</main>
</body>
