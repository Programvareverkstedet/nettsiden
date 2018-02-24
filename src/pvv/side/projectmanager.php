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
				$dbProj['owneremail'],
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
			$dbProj['owneremail'],
			$dbProj['active']
		);

		return $project;
	}

	public function getByUName($uname){
		$query = 'SELECT * FROM projects WHERE owneruname=:uname';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
		$statement->execute();

		$projects = [];
		foreach($statement->fetchAll() as $dbProj){
			$project = new Project(
				$dbProj['id'],
				$dbProj['name'],
				$dbProj['description'],
				$dbProj['owner'],
				$dbProj['owneruname'],
				$dbProj['owneremail'],
				$dbProj['active']
			);
			$projects[] = $project;
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
			$members[] = ['name' => $dbUsr['name'], 'uname' => $dbUsr['uname'], 'role' => $dbUsr['role']];
		}

		return $members;
	}
}