<?php

declare(strict_types=1);
require __DIR__ . '/../src/_autoload.php';
require __DIR__ . '/../config.php';

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$agenda = new pvv\side\Agenda([
  new pvv\side\social\NerdepitsaActivity(),
  new pvv\side\social\AnimekveldActivity(),
  new pvv\side\DBActivity($pdo),
]);
