<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
error_reporting(E_ALL);
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../config.php';
$pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if(!isset($_POST['title']) or !isset($_POST['content'])){
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

if(!$userManager->isAdmin($uname)){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}


$motdfetcher = new \pvv\side\MOTD($pdo);
$motdfetcher->setMOTD($_POST['title'], $_POST['content']);

header('Location: .');
?>

<a href=".">Om du ikke ble automatisk omdirigert tilbake klikk her</a>
