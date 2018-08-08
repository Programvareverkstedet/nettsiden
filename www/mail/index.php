<?php 
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
?>
<!DOCTYPE html>
<html lang=no>
<style>
p {hyphens: auto;}
</style>
<title>Programvareverkstedet</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/mail.css">

<header>Programvare&shy;verk&shy;stedet</header>

<main>

<ul id="webmail">
	<li id="squirrelmail"><div><a href="https://webmail.pvv.ntnu.no/squirrelmail/">squirrelmail</a>
	<li id="roundcube"><div><a href="https://webmail.pvv.ntnu.no/roundcube/">roundcube</a>
	<li id="rainloop"><div><a href="https://webmail.pvv.ntnu.no/rainloop/">rainloop</a>
</ul>

</main>

<nav>
	<?= navbar(1, "mail"); ?>
	<?= loginbar($sp, $pdo); ?>
</nav>
