<?php //declare(strict_types=1);
namespace pvv\side;

use \DateTimeImmutable;
use \DateInterval;

abstract class Event {

	private $start;

	public function __construct(DateTimeImmutable $start) {
		$this->start = $start;
	}

	public function getStart() {
		return $this->start;
	}

	public function getRelativeDate() {
		if (Agenda::isToday($this->getStart())) {
			return 'i dag';
		}
		if (Agenda::isTomorrow($this->getStart())) {
			return 'i morgen';
		}
		if (Agenda::isThisWeek($this->getStart()) || $this->getStart()->sub(new DateInterval('P4D'))->getTimestamp() < time()) {
			return $this->getStart()->format("l");
		}
		if (Agenda::isNextWeek($this->getStart())) {
			return 'neste uke';
		}
		if (Agenda::isThisMonth($this->getStart())) {
			return 'denne måneden';
		}
		return $this->getStart()->format("j. F");
	}

	public abstract function getStop(); /* : DateTimeImmutable */

	public abstract function getName();

	public abstract function getLocation();

	public abstract function getOrganiser();

	public abstract function getURL(); /* : string */

	public abstract function getImageURL(); /* : string */

	public abstract function getDescription(); /* : string */

	public abstract function getColor(); /* : string */
}
