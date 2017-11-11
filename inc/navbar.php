<?php
function navbar($depth, $active = NULL) {
	$result = "\n\t<ul>\n";
	$menuItems = [
		'hjem' => '',
		'kalender' => 'kalender',
		'aktiviteter' => 'aktiviteter',
		'prosjekter' => 'prosjekt',
		'kontakt' => 'kontakt',
		'wiki' => 'pvv',
	];
	foreach($menuItems as $caption => $link) {
		$result .= "\t\t<li" . ($active === $link ? ' class="active"' : '') . '>'
			. '<a href="' . str_repeat('../', $depth) . $link . '/">'
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

	$attr = $as->getAttributes();
	if($attr) {
		$uname = $attr['uid'][0];
		$result .= "\t<p class=\"login\">logget inn som: " . htmlspecialchars($uname) . "</p>\n";
	} else {
		$result .= "\t<a class=\"login\" href=\"" . htmlspecialchars($as->getLoginURL()) . "\">logg inn</a>\n";
	}

	return $result;
}
