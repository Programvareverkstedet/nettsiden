<?php
namespace pvv\side;

use \PDO;

class MOTD{
	private $pdo;

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function getMOTD(){
		$query = 'SELECT * FROM motd LIMIT 1';
		$statement = $this->pdo->prepare($query);
		$statement->execute();

		$data = $statement->fetch();
		$motd = array("title" => $data[0], "content" => explode("\n", $data[1]));

		return $motd;
	}
}