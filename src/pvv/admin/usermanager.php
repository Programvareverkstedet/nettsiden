<?php
namespace pvv\admin;

use \PDO;

class UserManager{
	private $pdo;

	public $usergroups = [
		'admin' => 1,
		'prosjekt' => 2,
		'aktiviteter' => 4
	];

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function setupUser($uname, $groups=0){
		$query = 'INSERT INTO users (uname, groups) VALUES (:uname, :groups)';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
		$statement->bindParam(':groups', $groups, PDO::PARAM_INT);
		$statement->execute();
	}

	public function updateFlags($uname, $flags){
		$query = 'UPDATE users set groups=:groups WHERE uname=:uname';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':groups', $flags, PDO::PARAM_INT);
		$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
	}

	public function addGroup($uname, $group){
		$userFlags = $this->getUsergroups();

		if($userFlags){
			$newFlags = ($group | $userFlags);
			$this->updateFlags($uname, $newFlags);
		}
	}

	public function removeGroup($uname, $group){
		$userFlags = $this->getUsergroups();

		if($userFlags){
			$newFlags = ($userFlags & (~ $group));
			$this->updateFlags($uname, $newFlags);
		}
	}

	public function setGroups($uname, $groups){
		$query = 'SELECT * FROM users WHERE uname=:uname LIMIT 1';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
		$statement->execute();
		$row = $statement->fetch();

		if($row){
			$query = 'UPDATE users set groups=:groups WHERE uname=:uname';
			$statement = $this->pdo->prepare($query);
			$statement->bindParam(':groups', $groups, PDO::PARAM_INT);
			$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
			$statement->execute();
		}else{
			$this->setupUser($uname, $groups);
		}
	}

	public function hasGroup($uname, $groupName){
		$userFlags = $this->getUsergroups($uname);

		return ($userFlags & $this->usergroups[$groupName]);
	}

	// for convenience
	public function isAdmin($uname){
		return $this->hasGroup($uname, 'admin');
	}

	public function getFlagfromNames($names){
		$resultFlag = 0;

		foreach($this->usergroups as $name => $flag){
			if(in_array($name, $names)){
				$resultFlag = ($resultFlag | $flag);
			}
		}

		return $resultFlag;
	}

	public function getUsergroups($uname){
		$query = 'SELECT groups FROM users WHERE uname=:uname LIMIT 1';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':uname', $uname, PDO::PARAM_STR);
		$statement->execute();

		return $statement->fetch()[0];
	}

	public function getUsergroupNames($uname){
		$usersGroups = [];

		$userFlags = $this->getUsergroups($uname);

		foreach($this->usergroups as $name => $flag){
			if($userFlags & $flag){
				$usersGroups[] = $name;
			}
		}

		return $usersGroups;
	}

	public function getAllUserData(){
		$query = 'SELECT uname FROM users ORDER BY uname ASC';
		$statement = $this->pdo->prepare($query);
		$statement->execute();

		$users = [];
		foreach($statement->fetchAll() as $userData){
			$uname = $userData['uname'];
			$users[] = [
				'name' => $uname,
				'groups' => $this->getUsergroupNames($uname)
			];
		}

		return $users;
	}
}