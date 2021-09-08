<?php
namespace pvv\side;

use \PDO;

class Door{
	private $pdo;

	public function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}

	public function getAll() {
		$query = 'SELECT time, open FROM door ORDER BY time DESC';
		$statement = $this->pdo->prepare($query);
		$statement->execute();

		$doorEvents = [];
		foreach($statement->fetchAll() as $row){
			$doorEvents[] = [
				'time'        => (int)$row['time'],
				'open'        => (bool)$row['open']
			];
		}

		return $doorEvents;
	}

	public function getEntriesAfter($startTime) {
		$query = 'SELECT time, open FROM door WHERE time > :startTime ORDER BY time DESC';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':startTime', $startTime, PDO::PARAM_STR);
		$statement->execute();

		$doorEvents = [];
		foreach($statement->fetchAll() as $row){
			$doorEvents[] = [
				'time'        => (int)$row['time'],
				'open'        => (bool)$row['open']
			];
		}

		return $doorEvents;
	}

	public function getCurrent() {
		$query = 'SELECT time, open FROM door ORDER BY time DESC LIMIT 1';
		$statement = $this->pdo->prepare($query);
		$statement->execute();
		$row = $statement->fetch();
		return [
			'time'        => (int)$row['time'],
			'open'        => (bool)$row['open']
		];
	}

	private function removeOld() {
		$firstValidTime = time() - 60*60*24*7; //One week before now
		$query = 'DELETE FROM door WHERE time < :firstValid';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':firstValid', $firstValidTime, PDO::PARAM_STR);
		$statement->execute();
	}

	public function createEvent($time, $open) {
		$query = 'INSERT INTO door(time, open) VALUES (:time, :open)';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':time', $time, PDO::PARAM_STR);
		$statement->bindParam(':open', $open, PDO::PARAM_STR);
		$statement->execute();

		$this->removeOld();
	}
}
