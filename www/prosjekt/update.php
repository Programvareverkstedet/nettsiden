<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!isset($_POST['title']) or !isset($_POST['desc'])){
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

require_once(__DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();

$id = 0;
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$active = $_POST['active'];
}

$title = $_POST['title'];
$desc = $_POST['desc'];
$owner = $attrs['cn'][0];
$owneruname = $attrs['uid'][0];

$statement;
if($id == 0){
	$query = 'INSERT INTO projects (name, owner, owneruname, description, active) VALUES (:title, :owner, :owneruname, :desc, 1)';
	$statement = $pdo->prepare($query);

	$statement->bindParam(':title', $title, PDO::PARAM_STR);
	$statement->bindParam(':desc', $desc, PDO::PARAM_STR);
	$statement->bindParam(':owner', $owner, PDO::PARAM_STR);
	$statement->bindParam(':owneruname', $owneruname, PDO::PARAM_STR);
}else{
	$query = 'UPDATE projects SET name=:title, owner=:owner, owneruname=:owneruname, description=:desc WHERE id=:id';
	$statement = $pdo->prepare($query);

	$statement->bindParam(':title', $title, PDO::PARAM_STR);
	$statement->bindParam(':desc', $desc, PDO::PARAM_STR);
	$statement->bindParam(':owner', $owner, PDO::PARAM_STR);
	$statement->bindParam(':owneruname', $owneruname, PDO::PARAM_STR);
	$statement->bindParam(':id', $id, PDO::PARAM_INT);
}

$statement->execute();

header('Location: ./mine.php');
?>

<a href="..">Om du ikke ble omdirigert tilbake klikk her</a>