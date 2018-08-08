<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../sql_config.php';
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!isset($_POST['title']) or !isset($_POST['desc']) or !isset($_POST['active'])){
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit();
}

require_once(__DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();

$id = $_POST['id'];
$do_delete = isset($_POST['delete']);
$do_join_or_leave = isset($_POST['join_or_leave']);

$active = $_POST['active'];

$title = $_POST['title'];
$desc = $_POST['desc'];
$name = $attrs['cn'][0];
$uname = $attrs['uid'][0];
$mail = $attrs['mail'][0];

$statement;
if($id == 0){
	$query = 'INSERT INTO projects (name, description, active) VALUES (:title, :desc, 1)';
	$statement = $pdo->prepare($query);

	$statement->bindParam(':title', $title, PDO::PARAM_STR);
	$statement->bindParam(':desc', $desc, PDO::PARAM_STR);

	$statement->execute();
	$new_id = $pdo->lastInsertId();

	$ownerQuery = "INSERT INTO projectmembers (projectid, name, uname, mail, role, lead, owner) VALUES (:id, :owner, :owneruname, :owneremail, 'Prosjektleder', 1, 1)";
	$statement = $pdo->prepare($ownerQuery);
	$statement->bindParam(':id', $new_id, PDO::PARAM_STR);
	$statement->bindParam(':owner', $name, PDO::PARAM_STR);
	$statement->bindParam(':owneruname', $uname, PDO::PARAM_STR);
	$statement->bindParam(':owneremail', $mail, PDO::PARAM_STR);

	$statement->execute();
}
else {
	$projectManager = new \pvv\side\ProjectManager($pdo);
	$owner = $projectManager->getProjectOwner($id);
	$members = $projectManager->getProjectMembers($id);

	//if ($do_join_or_leave and $owner['uname'] != $uname) {
	if ($do_join_or_leave) {
		$is_member = False;
		foreach($members as $member){
			if ($member['uname'] == $uname and $member['owner']==0){
				$is_member = True;
				break;
			}
		}
		if ($is_member){//leave
			$query = "DELETE FROM projectmembers WHERE projectid=:id AND uname=:uname and lead=0 and owner=0;";
			$statement = $pdo->prepare($query);
			$statement->bindParam(':id', $id, PDO::PARAM_STR);
			$statement->bindParam(':uname', $uname, PDO::PARAM_STR);

			$statement->execute();
			print("leave");
		}
		else{//join
			$query = "INSERT INTO projectmembers (projectid, name, uname, mail, role, lead, owner) VALUES (:id, :name, :uname, :mail, 'Medlem', 0, 0)";
			$statement = $pdo->prepare($query);
			$statement->bindParam(':id', $id, PDO::PARAM_STR);
			$statement->bindParam(':name', $name, PDO::PARAM_STR);
			$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
			$statement->bindParam(':mail', $mail, PDO::PARAM_STR);

			$statement->execute();
			print("join");
		}
		header('Location: ./info.php?id=' . $id);
		exit();
	}

	if($uname != $owner['uname']){
		header('Content-Type: text/plain', true, 403);
		echo "Illegal action, you're not the project owner for project with ID " . $id . "\r\n";
		exit();
	}
	
	if ($do_delete) {
		// this should be done as a transaction...
		$pdo->beginTransaction();
	
		$query = 'DELETE FROM projects WHERE id=:id';
		$statement = $pdo->prepare($query);
		$statement->bindParam(':id', $id, PDO::PARAM_INT);
		$statement->execute();
		
		$query = 'DELETE FROM projectmembers WHERE projectid=:id';
		$statement = $pdo->prepare($query);
		$statement->bindParam(':id', $id, PDO::PARAM_INT);
		$statement->execute();
		
		$pdo->commit();
	}else{
		$query = 'UPDATE projects SET name=:title, description=:desc WHERE id=:id';
		$statement = $pdo->prepare($query);

		$statement->bindParam(':title', $title, PDO::PARAM_STR);
		$statement->bindParam(':desc', $desc, PDO::PARAM_STR);
		$statement->bindParam(':id', $id, PDO::PARAM_INT);
		
		$statement->execute();
	}
}

header('Location: ./mine.php');
?>

<a href="..">Om du ikke ble omdirigert tilbake klikk her</a>
