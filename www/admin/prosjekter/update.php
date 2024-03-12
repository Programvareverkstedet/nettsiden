<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../config.php';
$pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if(!$userManager->hasGroup($uname, 'prosjekt')){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}

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
$name = $_POST['organisername'];
$uname = $_POST['organiser'];
$mail = $_POST['organiseremail'];
$active = (isset($_POST['active']) ? $_POST['active'] : 0);

$statement;
if($id == 0){
	$query = 'INSERT INTO projects (name, description, active) VALUES (:title, :desc, :active)';
	$statement = $pdo->prepare($query);

	$statement->bindParam(':title', $title, PDO::PARAM_STR);
	$statement->bindParam(':desc', $desc, PDO::PARAM_STR);
	$statement->bindParam(':active', $active, PDO::PARAM_INT);

	$statement->execute();

	$ownerQuery = 'INSERT INTO projectmembers (projectid, name, uname, mail, role, lead, owner) VALUES (last_insert_rowid(), :owner, :owneruname, :owneremail, \'Prosjektleder\', 1, 1)';
	$statement = $pdo->prepare($ownerQuery);
	$statement->bindParam(':owner', $name, PDO::PARAM_STR);
	$statement->bindParam(':owneruname', $uname, PDO::PARAM_STR);
	$statement->bindParam(':owneremail', $mail, PDO::PARAM_STR);

	$statement->execute();
}else{
	$query = 'UPDATE projects SET name=:title, description=:desc, active=:active WHERE id=:id';
	$statement = $pdo->prepare($query);

	$statement->bindParam(':title', $title, PDO::PARAM_STR);
	$statement->bindParam(':desc', $desc, PDO::PARAM_STR);
	$statement->bindParam(':active', $active, PDO::PARAM_INT);
	$statement->bindParam(':id', $id, PDO::PARAM_INT);

	$statement->execute();

	$query = 'UPDATE projectmembers SET name=:name, uname=:uname, mail=:mail';
	$statement = $pdo->prepare($query);

	$statement->bindParam(':name', $name, PDO::PARAM_STR);
	$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
	$statement->bindParam(':mail', $mail, PDO::PARAM_STR);

	$statement->execute();
}

header('Location: .');
?>

<a href=".?page=1">Om du ikke ble automatisk omdirigert tilbake klikk her</a>