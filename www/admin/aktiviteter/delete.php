<?php
require __DIR__ . '/../../../src/_autoload.php';
require __DIR__ . '/../../../sql_config.php';
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$eventID = $_GET['id'];

$query = 'DELETE FROM events WHERE id=\'' . $eventID . '\'';
$statement = $pdo->prepare($query);
$statement->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>