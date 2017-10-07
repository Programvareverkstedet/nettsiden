<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if($_POST["firstname"] == null &&
		$_POST["lastname"] == null &&
		$_POST["username"] == null &&
		$_POST["email"] == null) {
		var_export($_POST);
	}
	else {
		$membersFile = "members.json";
		$members = json_decode(file_get_contents($membersFile), true);
		$newMember = array(
			'firstname' => $_POST["firstname"],
			'lastname' => $_POST["lastname"],
			'username' => $_POST["username"],
			'email' => $_POST["email"]);
		array_push($members, $newMember);
		file_put_contents($membersFile, json_encode($members));
	}
	header('Location: .');
die();
}
?>

<!DOCTYPE html>
<title>PVV registrering</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">

<header>Programvareverkstedet</header>
<div>
	<form>
		<div>
			First name:
			<input type="text" name="firstname">
		</div>
		<div>
			Last name:
			<input type="text" name="lastname">
		</div>
		<div>
			NTNU username:
			<input type="text" name="username">
		</div>
		<div>
			Email adress:
			<input type="text" name="email">
		</div>
		<input type="submit" value="Submit">
	</form>
</div>


