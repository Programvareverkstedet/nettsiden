<?php

require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

header('Content-Type: application/json');
$door = new \pvv\side\Door($pdo);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SERVER["HTTP_AUTHORIZATION"])) {
        list($type, $data) = explode(" ", $_SERVER["HTTP_AUTHORIZATION"], 2);
        if (strcasecmp($type, "Bearer") == 0) {
            if (hash_equals($data, $doorSensorSecret)) {
                handleSetState();
            } else {
                echo '{"status": "error", "message": "Invalid authentication key"}';
                die();
            }
        } else {
            echo '{"status": "error", "message": "Invalid authentication method"}';
            die();
        }
    } else {
        echo '{"status": "error", "message": "Missing authentication"}';
        die();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET["period"])) {
        $period = (string)htmlspecialchars($_GET["period"]);
        
        if ($period == "day") {
            $startTime = time() - (60*60*24);
        } else if ($period == "week") {
            $startTime = time() - (60*60*24*7);
        } else {
            echo '{"status": "error", "message": "Invalid period"}';
            die();
        }

        $lines = $door->getEntriesAfter($startTime);
        if (isset($_GET["edgeonly"]) && (bool)htmlspecialchars($_GET["edgeonly"])) {
            //Ignore repeats
            $lines = getChanges($lines);
        }
        
        echo json_encode([
            'status'        => "OK",
            'entries'       => $lines
        ]);
    } else {
        //Only last entry
        $line = (object)$door->getCurrent();
        echo json_encode([
            'status'        => "OK",
            'time'          => $line->time,
            'open'          => $line->open
        ]);
    }
}


function handleSetState() {
    global $door;

    $jsonobj = file_get_contents('php://input');
    $event = json_decode($jsonobj);

    if ((!isset($event->time)) || (!is_numeric($event->time))) {
        echo '{"status": "error", "message": "Invalid timestamp"}';
        die();
    }
    if ((!isset($event->isDoorOpen)) || (!is_bool($event->isDoorOpen))) {
        echo '{"status": "error", "message": "Invalid door state"}';
        die();
    }

    $door->createEvent((int)($event->time), $event->isDoorOpen ? 1 : 0);
    echo '{"status": "OK"}';
} 

function getChanges($items) {
    $prevState = 2;
    $res = [];

    foreach($items as $item) {
        if ($item["open"] !== $prevState) {
            array_push($res, $item);
            $prevState = $item["open"];
        }
    }

    return $res;
}
