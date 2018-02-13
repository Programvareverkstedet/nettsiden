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

	$svgWhite = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 64 64">
	<circle cx="32" cy="27" r="14" stroke-width="0" fill="white" />
	<ellipse cx="32" cy="66" rx="24" ry="28" stroke-width="0" fill="white" />
</svg>
';
	$svgBlue = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 64 64">
	<circle cx="32" cy="27" r="14" stroke-width="0" fill="#024" />
	<ellipse cx="32" cy="66" rx="24" ry="28" stroke-width="0" fill="#024" />
</svg>
';

	$attr = $as->getAttributes();
	if($attr) {
		$uname = $attr['uid'][0];
		$result .= "\t<a id=\"login\" href=\"#usermenu\" aria-hidden=\"true\">${svgWhite}" . htmlspecialchars($uname) . "</a>\n";

		$result .= "\n\t<ul id=\"usermenu\">\n";
		$result .= "\n\t\t<li><a id=\"login\" href=\"#\">${svgBlue}" . htmlspecialchars($uname) . "</a></li>\n";
		$result .= "\n\t\t<li><a href=\"" . htmlspecialchars($as->getLogoutURL()) . "\">Logg ut</a></li>\n";
		$result .= "\n\t</ul>\n";
	} else {
		$result .= "\t<a id=\"login\" href=\"" . htmlspecialchars($as->getLoginURL()) . "\">${svgWhite}Logg inn</a>\n";
	}

	$result .= "\n\t<a href=\"#menu\" id=\"menu_toggle\" aria-hidden=\"true\"><big>&#9776;&nbsp;</big>MENU</a>\n";

	return $result;
}
