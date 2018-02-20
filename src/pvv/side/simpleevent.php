<?php
namespace pvv\side;

class SimpleEvent extends Event {

	private $id, $name, $descr, $start, $end, $org, $loc;

	public function __construct($id, $name,\DateTimeImmutable $start,\DateTimeImmutable $end,$org, $loc, $descr, $isDBEvent = false){
		$this->id = $id;
		$this->name = $name;
		$this->start = $start;
		$this->end = $end;
		$this->org = $org;
		$this->loc = $loc;
		$this->descr = explode("\n", $descr);
		$this->isDBEvent = $isDBEvent;
	}

	public function getID(){
		return $this->id;
	}

	public function getStart(){
		return $this->start;
	}

	public function getStop(){
		return $this->end;
	}

	public function getOrganiser(){
		return $this->org;
	}

	public function getLocation(){
		return $this->loc;
	}

	public function getName(){
		return $this->name;
	}

	public function getURL() {
		return '';
	}

	public function getImageURL() {
		return null;
	}

	public function getDescription() {
		return array_map(function ($item) {return "<p>".$item;}, $this->descr);
	}

	public function isDBEvent() {
		return $this->isDBEvent;
	}

}
