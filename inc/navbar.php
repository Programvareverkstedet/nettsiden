<?php
function navbar($depth, $active = NULL) {
	$result = "\n\t<ul id=\"menu\">\n";
	$menuItems = [
		'Hjem' => '',
		'Kalender' => 'kalender',
		'Aktiviteter' => 'aktiviteter',
		'Prosjekter' => 'prosjekt',
		'Kontakt' => 'kontakt',
		'Webmail' => 'https://webmail.pvv.ntnu.no/',
		'Wiki' => 'pvv',
	];
	foreach($menuItems as $caption => $link) {
		$isActive = $active === $link;
		if ($caption !== 'webmail') {
			$link = rtrim(str_repeat('../', $depth) . $link, '/') . '/';
		}
		$result .= "\t\t<li" . ($isActive ? ' class="active"' : '') . '>'
			. '<a href="' . $link . '">'
			. $caption
			. "</a></li>\n"
			;
	}
	return $result . "\t</ul>\n";
}

function loginBar($sp = 'default-sp') {
	$result = "\n";
	require_once(__DIR__ . '/../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
	$as = new SimpleSAML_Auth_Simple($sp);

	$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 64 64">
	<circle cx="32" cy="27" r="14" stroke-width="0" fill="white" />
	<ellipse cx="32" cy="66" rx="24" ry="28" stroke-width="0" fill="white" />
</svg>
';

	$attr = $as->getAttributes();
	if($attr) {
		$uname = $attr['uid'][0];
		$result .= "\t<p id=\"login\">logget inn som: " . htmlspecialchars($uname) . "</p>\n";
	} else {
		$result .= "\t<a id=\"login\" href=\"" . htmlspecialchars($as->getLoginURL()) . "\">${svg}Logg inn</a>\n";
	}
	$result .= "\t<a href=\"#menu\" id=\"menu_toggle\"><big>&#9776;&nbsp;</big>MENU</a>\n";

	return $result;
}
