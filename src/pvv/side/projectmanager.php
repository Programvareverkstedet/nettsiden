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
		if (!$dbProj) {
			return false;
		}
		$project = new Project(
			$dbProj['id'],
			$dbProj['name'],
			$dbProj['description'],
			$dbProj['active']
		);

		return $project;
	}

	public function getByOwner($uname){
		$query = 'SELECT projectid FROM projectmembers WHERE uname=:uname';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
		$statement->execute();

		$projectIDs = $statement->fetchAll();
		$projects = [];
		foreach($projectIDs as $id){
			$id = $id['projectid'];
			
			$query = 'SELECT * FROM projects WHERE id=:id';
			$statement = $this->pdo->prepare($query);
			$statement->bindParam(':id', $id, PDO::PARAM_INT);
			$statement->execute();
			
			foreach($statement->fetchAll() as $dbProj){
				$project = new Project(
					$dbProj['id'],
					$dbProj['name'],
					$dbProj['description'],
					$dbProj['active']
				);
				$projects[] = $project;
			}
		}

		return $projects;
	}

	public function getProjectMembers($id){
		$query = 'SELECT * FROM projectmembers WHERE projectid=:id';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();

		$members = [];
		foreach($statement->fetchAll() as $dbUsr){
			$members[] = [
				'name' => $dbUsr['name'],
				'uname' => $dbUsr['uname'],
				'mail' => $dbUsr['mail'],
				'role' => $dbUsr['role'],
				'lead' => $dbUsr['lead'],
				'owner' => $dbUsr['owner']
			];
		}

		return $members;
	}

	public function getProjectOwner($id){
		$query = 'SELECT * FROM projectmembers WHERE (projectid=:id AND owner=1)';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':id', $id, PDO::PARAM_STR);
		$statement->execute();

		$dbOwner = $statement->fetch();
		$owner = [
			'name' => $dbOwner['name'],
			'uname' => $dbOwner['uname'],
			'mail' => $dbOwner['mail'],
			'role' => $dbOwner['role'],
			'lead' => $dbOwner['lead'],
			'owner' => $dbOwner['owner']
		];

		return $owner;
	}
}
