<?php

declare(strict_types=1);
// Set up database and user system,
// and include common files such as HTML includes or SimplSAMLphp.

require_once __DIR__ . \DIRECTORY_SEPARATOR . 'agenda.php';
require_once __DIR__ . \DIRECTORY_SEPARATOR . 'navbar.php';

require_once dirname(__DIR__) . implode(\DIRECTORY_SEPARATOR, ['', 'config.php']);

require_once dirname(__DIR__) . implode(\DIRECTORY_SEPARATOR, ['', 'src', '_autoload.php']);
require_once dirname(__DIR__) . implode(\DIRECTORY_SEPARATOR, ['', 'vendor', 'simplesamlphp', 'simplesamlphp', 'lib', '_autoload.php']);

date_default_timezone_set('Europe/Oslo');
setlocale(\LC_ALL, 'nb_NO');

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$userManager = new pvv\admin\UserManager($pdo);

$sp = 'default-sp';
$as = new SimpleSAML\Auth\Simple($sp);

use pvv\side\Agenda;

$agenda = new Agenda([
  // new \pvv\side\social\NerdepitsaActivity,
  // new \pvv\side\social\AnimekveldActivity,
  new pvv\side\social\HackekveldActivity(),
  new pvv\side\social\BrettspillActivity(),
  new pvv\side\social\DriftkveldActivity(),
  new pvv\side\DBActivity($pdo),
]);

$months_translations = ['januar', 'februar', 'mars', 'april', 'mai', 'juni', 'juli', 'august', 'september', 'oktober', 'november', 'desember'];
