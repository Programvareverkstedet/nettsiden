<?php
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if(!$userManager->hasGroup($uname, 'prosjekt')){
	echo 'Ingen tilgang';
	exit();
}

$projectID = $_GET['id'];

$query = 'DELETE FROM projects WHERE id=\'' . $projectID . '\'';
$statement = $pdo->prepare($query);
$statement->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>

<a href=".?page=1">Om du ikke ble omdirigert tilbake klikk her</a>