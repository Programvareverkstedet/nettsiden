<?php
require_once '../../lib/OAuth2-Client/OAuth2Client.php';
require_once '../../dataporten_config.php';

$oauth2 = new Kasperrt\Oauth2($dataportenConfig);

session_start();
if (isset($_GET['logout'])) {
	session_destroy();
	header('Location: http://[::1]:1080/paamelding/');
	die();
}

if (isset($_GET['code'])) {
	$token = $oauth2 -> get_access_token();
	error_log($token);
	$_SESSION['userdata'] = $oauth2 -> get_identity($token, 'https://auth.dataporten.no/userinfo');
	header('Location: http://[::1]:1080/paamelding/');
	die();
}
if (!isset($_SESSION['userdata'])) {
	$oauth2 -> redirect();
	die();
}

//var_export($_SESSION);
//exit;

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
			Full name:
			<input type="text" name="lastname" value="<?= $_SESSION['userdata']['user']['name'] ?>" readonly>
		</div>
		<div>
			NTNU username:
			<input type="text" name="username" value="<?= $_SESSION['userdata']['user']['userid_sec'][0] ?>" readonly>
		</div>
		<div>
			Email adress:
			<input type="text" name="email" value="<?= $_SESSION['userdata']['user']['email'] ?>">
		</div>
		<input type="submit" value="Submit">
	</form>
</div>


