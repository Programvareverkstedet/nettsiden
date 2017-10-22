<?php
require_once(__DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();

$attributes = $as->getAttributes();
print_r($attributes);
?>

test
