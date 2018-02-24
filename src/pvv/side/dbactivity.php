<?php
namespace pvv\side;

use \DateTimeImmutable;
use \PDO;

class DBActivity implements Activity {

	public function __construct(PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function getAllEvents() {
		$query = 'SELECT * FROM events ORDER BY id ASC';
		$statement = $this->pdo->prepare($query);
		$statement->execute();

		$events = [];
		foreach($statement->fetchAll() as $dbEvent){
			$event = new SimpleEvent(
				$dbEvent['id'],
				$dbEvent['name'],
				DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dbEvent['start']),
				DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dbEvent['stop']),
				$dbEvent['organiser'],
				$dbEvent['location'],
				$dbEvent['description']
			);
			$events[] = $event;
		}

		return $events;
	}

	public function getEventByID($id) {
		$query = 'SELECT * FROM events WHERE id=:id LIMIT 1';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':id', $id, PDO::PARAM_INT);
		$statement->execute();

		$dbEvent = $statement->fetch();
		$event = new SimpleEvent(
			$dbEvent['id'],
			$dbEvent['name'],
			DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dbEvent['start']),
			DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dbEvent['stop']),
			$dbEvent['organiser'],
			$dbEvent['location'],
			$dbEvent['description']
		);

		return $event;
	}


	public function getNextEventFrom(DateTimeImmutable $date) {
		$query = 'SELECT id,name,start,stop,organiser,location,description FROM events WHERE start > :date ORDER BY start ASC LIMIT 1';
		return $this->retrieve($date, $query);
	}

	public function getPreviousEventFrom(DateTimeImmutable $date) {
		$query = 'SELECT id,name,start,stop,organiser,location,description FROM events WHERE start < :date ORDER BY start DESC LIMIT 1';
		return $this->retrieve($date, $query);
	}

	private function retrieve($date, $query) {
		$stmt = $this->pdo->prepare($query);
		$stmt->execute(['date' => $date->format('Y-m-d H:i:s')]);
		if ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
			$ev = new SimpleEvent(
				$result['id'],
				$result['name'],
				DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['start']),
				DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result['stop']),
				$result['organiser'],
				$result['location'],
				$result['description']
			);
			return $ev;
		}
		return null;
	}

}
