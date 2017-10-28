<?php
namespace pvv\side;

use \PDO;

class ProjectManager{
	private $pdo;

	public function __construct(PDO $pdo){
		$this->pdo = $pdo;
	}

	public function getAll() {
		$query = 'SELECT * FROM projects ORDER BY id ASC';
		$statement = $this->pdo->prepare($query);
		$statement->execute();

		$projects = [];
		foreach($statement->fetchAll() as $dbProj){
			$project = new Project(
				$dbProj['id'],
				$dbProj['name'],
				$dbProj['description'],
				$dbProj['owner'],
				$dbProj['owneruname'],
				$dbProj['active']
			);
			$projects[] = $project;
		}

		return $projects;
	}

	public function getByID($id){
		$query = 'SELECT * FROM projects WHERE id=:id LIMIT 1';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':id', $id, PDO::PARAM_INT);
		$statement->execute();

		$dbProj = $statement->fetch();
		$project = new Project(
			$dbProj['id'],
			$dbProj['name'],
			$dbProj['description'],
			$dbProj['owner'],
			$dbProj['owneruname'],
			$dbProj['active']
		);

		return $project;
	}
}