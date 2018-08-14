<?php 
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
?>
<!DOCTYPE html>
<html lang="no">
<style>
p {hyphens: auto;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/mail.css">
<meta name="theme-color" content="#024" />
<title>Mailverkstedet</title>

<header>Mail&shy;verk&shy;stedet</header>


<main>

<ul id="webmail">
	<li id="rainloop"><div><a href="https://webmail.pvv.ntnu.no/rainloop/"><span class="mailname">RainLoop</span></a>
	<li id="squirrelmail"><div><a href="https://webmail.pvv.ntnu.no/squirrelmail/"><span class="mailname">SquirrelMail</span></a>
	<li id="roundcube"><div><a href="https://webmail.pvv.ntnu.no/roundcube/"><span class="mailname">Roundcube</span></a>
</ul>

</main>

<nav>
	<?= navbar(1, "mail"); ?>
	<?= loginbar($sp, $pdo); ?>
</nav>
