<?php //declare(strict_types=1);
namespace pvv\side;

use \DateTimeImmutable;

abstract class Event implements Activity {

	private $start;

	public function __construct(DateTimeImmutable $start) {
		$this->start = $start;
	}

	public function getStart() {
		return $this->start;
	}

	public abstract function getStop(); /* : DateTimeImmutable */

}
