<?php //declare(strict_types=1);
namespace pvv\side\social;

ini_set('date.timezone', 'Europe/Oslo');

require implode(DIRECTORY_SEPARATOR, [dirname(dirname(dirname(__DIR__))), '', '_autoload.php']);

$c = new NerdepitsaActivity;
die($c->prevDate(new \DateTimeImmutable)->format(DATE_RFC2822));
