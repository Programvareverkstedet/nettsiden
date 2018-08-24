<?php
namespace pvv\side;

use \PDO;

class Doors{
	private $pdo;

	public function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}

	public function getAll() {
		$query = 'SELECT name, open, description FROM doors ORDER BY open DESC, name ASC';
		$statement = $this->pdo->prepare($query);
		$statement->execute();

		$doors = [];
		foreach($statement->fetchAll() as $row){
			$doors[] = [
				'name'        => $row['name'],
				'open'        => (int)$row['open'],
				'description' => $row['description'],
			];
		}

		return $doors;
	}

	public function getByName($name){
		$query = 'SELECT * FROM doors WHERE name=:name';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->execute();

		$row = $statement->fetch();
		if (!$row) {
			return false;
		}
		
		return [
			'name'        => $row['name'],
			'open'        => (int)$row['open'],
			'description' => $row['description'],
		];
	}
	
	public function setDoorState($name, $open) {
		$query = 'UPDATE doors SET open=:open WHERE name=:name';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->bindParam(':open', $open, PDO::PARAM_INT);
		$statement->execute();
	}
	
	
	public function createDoor($name, $description) {
		$query = 'INSERT INTO doors(name, open, description) VALUES (:name, TRUE, :desc)';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->bindParam(':desc', $description, PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function updateDoorDescription($name, $description) {
		$query = 'UPDATE doors SET descriptin=:desc WHERE name=:name';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->bindParam(':desc', $description, PDO::PARAM_STR);
		$statement->execute();
	}
	
	public function deleteDoor($name) {
		$query = 'DELETE FROM doors WHERE name = :name;';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':name', $name, PDO::PARAM_STR);
		$statement->execute();
	}
}
