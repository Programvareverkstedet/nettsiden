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

if(!$userManager->isAdmin($uname)){
	echo 'Her har du ikke lov\'t\'å\'værra!!!';
	exit();
}

$newUser;
if(isset($_POST['newuser'])){
	$newUser = $_POST['newuser'];
	unset($_POST['newuser']);	
}

$updatingUsers = explode('_', $_POST['users']);
unset($_POST['users']);

// 2d array of usernames and their corresponding group flags
$userFlags = [];
if($newUser){
	$userFlags[$newUser] = 0;
}

foreach($_POST as $namegroup => $info){
	$data = explode('_', $namegroup);
	if($data[0] == 'newuser'){
		if(!$newUser){
			continue;
		}

		$data[0] = $newUser;
	}

	if(!isset($userFlags[$data[0]])){
		$userFlags[$data[0]] = 0;
	}

	$userFlags[$data[0]] = ($userFlags[$data[0]] | $userManager->usergroups[$data[1]]);
}

foreach($updatingUsers as $uname){
	if(!array_key_exists($uname, $userFlags)){
		$userFlags[$uname] = 0;
	}
}

foreach($userFlags as $uname => $flag){
	$userManager->setGroups($uname, $flag);
}

header('Location: .');
?>

<a href=".">Om du ikke ble automatisk omdirigert tilbake klikk her</a>