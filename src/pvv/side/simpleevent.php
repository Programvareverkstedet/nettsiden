<?php
namespace pvv\side;

class SimpleEvent extends Event {

	private $name, $start, $end, $org, $loc;

	public function __construct($name,\DateTimeImmutable $start,\DateTimeImmutable $end,$org, $loc){
		$this->name = $name;
		$this->start = $start;
		$this->end = $end;
		$this->org = $org;
		$this->log = $loc;
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
		return '/';
	}

	public function getImageURL() {
		return null;
	}

	public function getDescription() {
		return [];
	}

}
