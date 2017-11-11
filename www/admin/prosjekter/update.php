<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!isset($_POST['title']) or !isset($_POST['desc']) or !isset($_POST['organisername']) or !isset($_POST['organiser'])){
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

$id = 0;
if(isset($_POST['id'])){
	$id = $_POST['id'];
}

$title = $_POST['title'];
$desc = $_POST['desc'];
$owner = $_POST['organisername'];
$uname = $_POST['organiser'];
$active = (isset($_POST['active']) ? $_POST['active'] : 0);

$statement;
if($id == 0){
	$query = 'INSERT INTO projects (name, owner, owneruname, description, active) VALUES (:title, :owner, :uname, :desc, :active)';
	$statement = $pdo->prepare($query);

	$statement->bindParam(':title', $title, PDO::PARAM_STR);
	$statement->bindParam(':desc', $desc, PDO::PARAM_STR);
	$statement->bindParam(':owner', $owner, PDO::PARAM_STR);
	$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
	$statement->bindParam(':active', $active, PDO::PARAM_INT);
}else{
	$query = 'UPDATE projects SET name=:title, owner=:owner, owneruname=:uname, description=:desc, active=:active WHERE id=:id';
	$statement = $pdo->prepare($query);

	$statement->bindParam(':title', $title, PDO::PARAM_STR);
	$statement->bindParam(':desc', $desc, PDO::PARAM_STR);
	$statement->bindParam(':owner', $owner, PDO::PARAM_STR);
	$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
	$statement->bindParam(':active', $active, PDO::PARAM_INT);
	$statement->bindParam(':id', $id, PDO::PARAM_INT);
}

$statement->execute();

header('Location: .');
?>

<a href=".?page=1">Om du ikke ble automatisk omdirigert tilbake klikk her</a>