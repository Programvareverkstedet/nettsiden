<?php
function navbar($depth, $active = NULL) {
	$result = "\n\t<ul id=\"menu\">\n";
	$menuItems = [
		'Hjem' => '',
		'Hendelser' => 'hendelser',
		//'Kalender' => 'kalender',
		//'Aktiviteter' => 'aktiviteter',
		'Prosjekter' => 'prosjekt',
		'Kontakt' => 'kontakt',
		'Webmail' => 'mail',
		'Galleri' => 'galleri',
		'Wiki' => 'https://wiki.pvv.ntnu.no/',
		'Git' => 'https://git.pvv.ntnu.no/',
                'Tjenester' => 'tjenester',
	];
	foreach($menuItems as $caption => $link) {
		$isActive = $active === $link;
		if (substr( $link, 0, 4 ) != "http") {
			$link = rtrim(str_repeat('../', $depth) . $link, '/') . '/';
		}
		
		//if ($isActive) $link = '#';
		
		$result .= "\t\t<li" . ($isActive ? ' class="active"' : '') . '>'
			. '<a href="' . $link . '">'
			. $caption
			. "</a></li>\n"
			;
	}
	return $result . "\t</ul>\n";
}

function loginBar($sp = null, $pdo = null) {
	if (is_null($sp)) $sp = 'default-sp';
	$result = "\n";
	require_once(__DIR__ . '/../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
	$as = new SimpleSAML_Auth_Simple($sp);

	$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 64 64">
	<circle cx="32" cy="27" r="14" stroke-width="0" />
	<ellipse cx="32" cy="66" rx="24" ry="28" stroke-width="0" />
</svg>
';

	$attr = $as->getAttributes();
	if($attr) {
		$uname = $attr['uid'][0];
		$isAdmin = false;
		if (isset($pdo)) {
			$userManager = new \pvv\admin\UserManager($pdo);
			$isAdmin = $userManager->isAdmin($uname);
		}
		$result .= "\t<a id=\"login\" href=\"#usermenu\" aria-hidden=\"true\">{$svg}" . htmlspecialchars($uname) . "</a>\n";

		$result .= "\n\t<ul id=\"usermenu\">\n";
		$result .= "\n\t\t<li><a id=\"login\" href=\"#\">{$svg}" . htmlspecialchars($uname) . "</a></li>\n";
		if ($isAdmin) {
			$result .= "\n\t\t<li><a href=\"/admin/\">Admin</a></li>\n";
		}
		$result .= "\n\t\t<li><a href=\"" . htmlspecialchars($as->getLogoutURL()) . "\">Logg ut</a></li>\n";
		$result .= "\n\t</ul>\n";
	} else {
		$result .= "\t<a id=\"login\" href=\"" . htmlspecialchars($as->getLoginURL()) . "\">{$svg}Logg inn</a>\n";
	}

	$result .= "\n\t<a href=\"#menu\" id=\"menu_toggle\" aria-hidden=\"true\"><big>&#9776;&nbsp;</big>MENU</a>\n";

	return $result;
}
