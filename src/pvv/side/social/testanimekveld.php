<?php

declare(strict_types=1);

namespace pvv\side\social;

ini_set('date.timezone', 'Europe/Oslo');

require implode(\DIRECTORY_SEPARATOR, [\dirname(__DIR__, 3), '', '_autoload.php']);

$c = new AnimekveldActivity();
exit($c->nextDate(new \DateTimeImmutable())->format(\DATE_RFC2822));
