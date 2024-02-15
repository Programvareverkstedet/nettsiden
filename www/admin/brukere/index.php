<?php
ini_set('display_errors', '1');
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');
error_reporting(E_ALL);
require __DIR__ . '/../../../inc/navbar.php';
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../config.php';
require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$attrs = $as->getAttributes();

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

require_once(__DIR__ . '/../../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if(!$userManager->isAdmin($uname)){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}

$users = $userManager->getAllUserData();
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/events.css">
<link rel="stylesheet" href="../../css/admin.css">
<meta name="theme-color" content="#024" />
<title>Brukeradministrasjonsverkstedet</title>

<header>Bruker&shy;administrasjons&shy;verk&shy;stedet</header>

<body>
	<nav>
		<?php echo navbar(2, 'admin'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Brukeradministrasjon</h2>
		<hr class="ruler">

		<form action="./update.php" method="post">
		<table class="userlist">
			<tr>
				<th>Brukernavn</th>
				<th>Brukergrupper</th>
			</tr>

			<?php
			$users_to_update = array();
			foreach($users as $i => $data){
				$uname = $data['name'];
				$groupFlag = $userManager->getUsergroups($uname);

				array_push($users_to_update, $uname);
			?>

				<tr>
					<td><?= $uname ?></td>
					<?php
					foreach($userManager->usergroups as $name => $group){
						echo '<td><input type="checkbox" ' . (($groupFlag & $group) ? 'checked' : '') . ' name="' . $uname . '_' . $name . '" class="usergroupcheckbox">' . $name . '</td>';
					}
					?>
				</tr>

			<?php
			}
			foreach($users_to_update as $uname) {
				echo '<input type="hidden" name="user_to_update" value="' . $uname . '" />';
			}
			
			?>

			<tr class="newuserrow">
				<td class="newuserelement"><input type="text" name="newuser" class="newuserinput"></td>
				<?php
					foreach($userManager->usergroups as $name => $group){
						echo '<td><input type="checkbox" name="newuser_' . $name . '" class="usergroupcheckbox">' . $name . '</td>';
					}
				?>
			</tr>
		</table>
		<input type="submit" class="btn" value="Lagre">
		</form>
	</main>
</body>
