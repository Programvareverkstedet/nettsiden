<?php
require_once(__DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attributes = $as->getAttributes();
?>

<p>
	Username: <?= $attributes["uid"][0]?><br>
	Full name: <?= $attributes["cn"][0]?><br>
	Email: <?= $attributes["mail"][0]?><br>
</p>

<a href="<?= htmlspecialchars($as->getLogoutURL("http://localhost:1080/")) ?>">logout</a>
