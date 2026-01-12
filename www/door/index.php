<?php

declare(strict_types=1);

require_once dirname(__DIR__, 2) . implode(\DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

header('Content-Type: application/json');
$door = new pvv\side\Door($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    [$type, $data] = explode(' ', $_SERVER['HTTP_AUTHORIZATION'], 2);
    if (strcasecmp($type, 'Bearer') == 0) {
      if (hash_equals($data, $DOOR_SECRET)) {
        handleSetState();
      } else {
        echo '{"status": "error", "message": "Invalid authentication key"}';
        exit;
      }
    } else {
      echo '{"status": "error", "message": "Invalid authentication method"}';
      exit;
    }
  } else {
    echo '{"status": "error", "message": "Missing authentication"}';
    exit;
  }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

  if (isset($_GET['period'])) {
    $period = (string) htmlspecialchars($_GET['period']);

    if ($period == 'day') {
      $startTime = time() - (60 * 60 * 24);
    } elseif ($period == 'week') {
      $startTime = time() - (60 * 60 * 24 * 7);
    } else {
      echo '{"status": "error", "message": "Invalid period"}';
      exit;
    }

    $lines = $door->getEntriesAfter($startTime);
    if (isset($_GET['edgeonly']) && (bool) htmlspecialchars($_GET['edgeonly'])) {
      // Ignore repeats
      $lines = getChanges($lines);
    }

    echo json_encode([
      'status'        => 'OK',
      'entries'       => $lines,
    ]);
  } else {
    // Only last entry
    $line = (object) $door->getCurrent();
    echo json_encode([
      'status'        => 'OK',
      'time'          => $line->time,
      'open'          => $line->open,
    ]);
  }
}


function handleSetState(): void {
  global $door;

  $jsonobj = file_get_contents('php://input');
  $event = json_decode($jsonobj);

  if ((!isset($event->time)) || (!is_numeric($event->time))) {
    echo '{"status": "error", "message": "Invalid timestamp"}';
    exit;
  }
  if ((!isset($event->isDoorOpen)) || (!is_bool($event->isDoorOpen))) {
    echo '{"status": "error", "message": "Invalid door state"}';
    exit;
  }

  $time = (new \DateTimeImmutable())->setTimestamp((int) $event->time);

  $door->createEvent($time, $event->isDoorOpen);
  echo '{"status": "OK"}';
}

function getChanges($items) {
  $prevState = 2;
  $res = [];

  foreach ($items as $item) {
    if ($item['open'] !== $prevState) {
      $res[] = $item;
      $prevState = $item['open'];
    }
  }

  return $res;
}
