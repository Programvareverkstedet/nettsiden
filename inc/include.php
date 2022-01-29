<?php
// Set up database and user system,
// and include common files such as HTML includes or SimplSAMLphp.

require_once __DIR__ . DIRECTORY_SEPARATOR . 'agenda.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'navbar.php';

require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['', 'lib', 'OAuth2-Client', 'OAuth2Client.php']);
require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['', 'dataporten_config.php']);

require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['', 'sql_config.php']);

require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['', 'src', '_autoload.php']);
require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['', 'vendor', 'simplesamlphp', 'simplesamlphp', 'lib', '_autoload.php']);

date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'nb_NO');

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new \pvv\admin\UserManager($pdo);

$sp = 'default-sp';
$as = new SimpleSAML_Auth_Simple($sp);

use \pvv\side\Agenda;
$agenda = new \pvv\side\Agenda([
		new \pvv\side\social\NerdepitsaActivity,
		// new \pvv\side\social\AnimekveldActivity,
        new \pvv\side\social\DriftkveldActivity,
		new \pvv\side\DBActivity($pdo),
	]);

$months_translations = ['januar', 'februar', 'mars', 'april', 'mai', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'desember'];
