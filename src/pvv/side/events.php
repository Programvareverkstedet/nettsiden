<?php
namespace pvv\side;
use \mysqli;
require __DIR__.'/sql_config.php';

Class Events {
    public function getAllEvents(){
	global $url, $user,$pass,$db;
	$events = array();
	$mysqli = new mysqli($url,$user,$pass,$db);
	$result = $mysqli->query("SELECT name,start,stop,organiser,location FROM events");
	while($row = $result->fetch_assoc()){
	$ev = new OnceEvent($row['name'],$row['start'],$row['stop'],$row['organiser'],$row['location']);
	array_push($events,$ev);
	}
	#array_sort($events);
	return $events;
    }
}

?>
