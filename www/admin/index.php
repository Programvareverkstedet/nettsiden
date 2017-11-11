<?php
require_once __DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';
$as = new SimpleSAML_Auth_Simple('default-sp');
$attrs = $as->getAttributes();
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
	<a class="btn adminbtn" href="aktiviteter/?page=1">Aktiviteter/Hendelser</a>
	<a class="btn adminbtn" href="prosjekter/">Prosjekter</a>
</article>

</main>

<nav>
	<?= navbar(1); ?>
	<?= loginbar(); ?>
</nav>
