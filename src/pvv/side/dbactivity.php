<?php
namespace pvv\side;

use \DateTimeImmutable;
use \PDO;

class DBActivity implements RepeatingActivity {

	public function __construct($dsn, $username, $password) {
		$this->pdo = new PDO($dsn, $username, $password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function getNextEventFrom(DateTimeImmutable $date) {
		$query = 'SELECT name,start,stop,organiser,location FROM events WHERE start > :date ORDER BY start ASC LIMIT 1';
		return $this->retrieve($date, $query);
	}

	public function getPreviousEventFrom(DateTimeImmutable $date) {
		$query = 'SELECT name,start,stop,organiser,location FROM events WHERE start < :date ORDER BY start DESC LIMIT 1';
		return $this->retrieve($date, $query);
	}

	private function retrieve($date, $query) {
		$stmt = $this->pdo->prepare($query);
		$stmt->execute(['date' => $date->format('Y-m-d H:i:s')]);
		if ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$ev = new OnceEvent(
				$result['name'],
				DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['start']),
				DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['stop']),
				$result['organiser'],
				$result['location']
			);
			return $ev;
		}
		return null;
	}

	public function getName() /* : string */ {
		return "Database";
	}

	public function getLocation() /* : Location */ {
		return "Location";
	}

	public function getOrganiser() /* : User */ {
		return "User";
	}

	/*
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
    */
}
