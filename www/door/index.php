<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
$doors = new \pvv\side\Doors($pdo);

$out = null;
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET["name"])) {
        $out = $doors->getByName($_GET["name"]);
        if (!$out) {
            echo '{"error": true, "reason": "not found"}';
            http_response_code(404);
            exit();
        }
    }
    else {
        $out = $doors->getAll();
    }
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["name"]) and isset($_POST["open"]) ) {
        $out = $doors->setDoorState($_POST["name"], (strtolower($_POST["open"])==="true")?1:0);
        
        $out = $doors->getByName($_POST["name"]);
        if (!$out) {
            echo '{"error": true, "reason": "not found"}';
            http_response_code(404);
            exit();
        }
    }
    else {
        echo '{"error": true, "reason": "missing either \"name\" or \"open\" argument"}';
        http_response_code(404);
        exit();
    }
}

echo json_encode($out);
