<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
error_reporting(E_ALL);
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

if(!isset($_POST['title']) or !isset($_POST['content'])){
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

if(!$userManager->isAdmin($uname)){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}

$query = 'UPDATE motd SET title=:title, content=:content';
$statement = $pdo->prepare($query);

$statement->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
$statement->bindParam(':content', $_POST['content'], PDO::PARAM_STR);

$statement->execute();

header('Location: .');
?>

<a href=".">Om du ikke ble automatisk omdirigert tilbake klikk her</a>