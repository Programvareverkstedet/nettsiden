<?php
namespace pvv\side;

use \PDO;

class MOTD{
	private $pdo;

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function setMOTD($title, $content) {
		if (is_array($content)) {
			$content = implode("_", $content);
		}
		$query = 'INSERT INTO motd(title, content) VALUES (:title, :content);';
		$statement = $this->pdo->prepare($query);

		$statement->bindParam(':title', $title, PDO::PARAM_STR);
		$statement->bindParam(':content', $content, PDO::PARAM_STR);

		$statement->execute();
	}
	
	public function getMOTD() {
		$query = 'SELECT motd.title, motd.content FROM motd ORDER BY motd.id DESC LIMIT 1';
		$statement = $this->pdo->prepare($query);
		$statement->execute();

		$data = $statement->fetch();
		$motd = array("title" => $data[0], "content" => explode("\n", $data[1]));

		return $motd;
	}
	
	public function getMOTD_history($limit = 5) {
		$query = 'SELECT motd.title, motd.content FROM motd ORDER BY motd.id DESC LIMIT :limit';
		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':limit', $limit, PDO::PARAM_STR);
		$statement->execute();

		$data = $statement->fetch();
		$motd = array("title" => $data[0], "content" => explode("\n", $data[1]));

		return $motd;
	}
	
}
