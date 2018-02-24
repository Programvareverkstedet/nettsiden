<?php
namespace pvv\side;

class Project{
	private $id, $name, $owner, $owneruname, $descr, $active;

	public function __construct($id, $name, $descr, $owner, $owneruname, $active){
		$this->id = $id;
		$this->name = $name;
		$this->descr = explode("\n", $descr);
		$this->owner = $owner;
		$this->owneruname = $owneruname;
		$this->active = $active;
	}

	public function getID(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

	public function getDescription(){
		return $this->descr;
	}

	public function getOwner(){
		return $this->owner;
	}

	public function getOwnerUName(){
		return $this->owneruname;
	}

	public function getActive(){
		return $this->active;
	}
}