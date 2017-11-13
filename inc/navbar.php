<?php
function navbar($depth, $active = NULL) {
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
	foreach($menuItems as $caption => $link) {
		$result .= "\t\t\t<a href=\"" . rtrim(str_repeat('../', $depth) . $link, '/') . "/\"" . ($active === $link ? ' class="active"' : '') . ">"
			. "<li>" . $caption . "</li></a>\n"
			;
	}
	$result .= "\t\t\t" . '<a href="javascript:void(0);" style="font-size:15px;" id="navopen" onclick="navbar()">&#9776;</a>' . "\n";
	return $result . "\t\t</ul>\n";
}

function loginBar($sp = 'default-sp') {
	$result = "\n";
	require_once(__DIR__ . '/../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
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
