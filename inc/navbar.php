<?php
function navbar($depth, $active = NULL, $sp = 'default-sp') {
	require __DIR__ . '/../src/_autoload.php';
	require_once __DIR__ . '/../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';
	require __DIR__ . '/../sql_config.php';

	$result = '<img class="logo" src="' . rtrim(str_repeat('../', $depth)) . "/css/logo-disk-white.png\"/>\n";
	$result .= "\t\t<ul>\n";
	$menuItems = [
		'Hjem' => '',
		'Kalender' => 'kalender',
		'Aktiviteter' => 'aktiviteter',
		'Prosjekter' => 'prosjekt',
		'Kontakt' => 'kontakt',
		'Wiki' => 'pvv'
	];

	$as = new SimpleSAML_Auth_Simple($sp);
	$attr = $as->getAttributes();
	if($attr) {
		$uname = $attr['uid'][0];

		$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$userManager = new \pvv\admin\UserManager($pdo);

		$isAdmin = $userManager->isAdmin($uname);
		$projectGroup = $userManager->hasGroup($uname, 'prosjekt');
		$activityGroup = $userManager->hasGroup($uname, 'aktiviteter');

		if($isAdmin | $projectGroup | $activityGroup) {
			$menuItems['Admin'] = 'admin';
		}
	}

	foreach($menuItems as $caption => $link) {
		$result .= "\t\t\t<a href=\"" . rtrim(str_repeat('../', $depth) . $link, '/') . "/\"" . ($active === $link ? ' class="active"' : '') . ">"
			. "<li>" . $caption . "</li></a>\n"
			;
	}
	$result .= "\t\t\t" . '<a href="javascript:void(0);" style="font-size:15px;" id="navopen" onclick="navbar()">&#9776;</a>' . "\n";
	return $result . "\t\t</ul>\n";
}

function loginBar($sp = 'default-sp') {
	require_once __DIR__ . '/../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';

	$result = "\n";
	$as = new SimpleSAML_Auth_Simple($sp);

	$attr = $as->getAttributes();
	if($attr) {
		$uname = $attr['uid'][0];
		$result .= "\t\t<p class=\"login\">Logget inn som: " . htmlspecialchars($uname) . "</p>\n";
	} else {
		$result .= "\t\t<a class=\"login\" href=\"" . htmlspecialchars($as->getLoginURL()) . "\">Logg inn</a>\n";
	}

	return $result;
}
