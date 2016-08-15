<?php //declare(strict_types=1);
namespace pvv\side\social;

use \pvv\side\RepeatingActivity;
use \DateTimeImmutable;
use \DateInterval;

class NerdepitsaActivity implements RepeatingActivity {

	public function nextDate(DateTimeImmutable $date) {
		if ($date->format('H') > 19)
			return $this->nextDate($date->add(new DateInterval('P1D'))->setTime(19, 0, 0));
		$date = $date->setTime(19, 0, 0);
		if ($date->format('N') != 5)
			return $this->nextDate($date->add(new DateInterval('P1D')));
		if ($date->format('W') % 2)
			return $this->nextDate($date->add(new DateInterval('P7D')));
		return $date;
	}

	public function prevDate(DateTimeImmutable $date) {
		if ($date->format('H') < 19)
			return $this->prevDate($date->sub(new DateInterval('P1D'))->setTime(19, 0, 0));
		$date = $date->setTime(19, 0, 0);
		if ($date->format('N') != 5)
			return $this->prevDate($date->sub(new DateInterval('P1D')));
		if ($date->format('W') % 2)
			return $this->prevDate($date->sub(new DateInterval('P7D')));
		return $date;
	}

	public function getNextEventFrom(DateTimeImmutable $date) /* : Event */ {
		return new NerdepitsaEvent($this->nextDate($date));
	}

	public function getPreviousEventFrom(DateTimeImmutable $date) /* : Event */ {
		return new NerdepitsaEvent($this->prevDate($date));
	}

	public function getName() /* : string */ {
		return "Nerdepitsa";
	}

	public function getLocation() /* : Location */ {
		return "Peppes Kjøpmansgata";
	}

	public function getOrganiser() /* : User */ {
		return "Anders Christensen";
	}

}
