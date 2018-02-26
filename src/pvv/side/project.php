<?php
namespace pvv\side;

class Project{
	private $id, $name, $descr, $active;

	public function __construct($id, $name, $descr, $active){
		$this->id = $id;
		$this->name = $name;
		$this->descr = explode("\n", $descr);
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

	public function getActive(){
		return $this->active;
	}
}