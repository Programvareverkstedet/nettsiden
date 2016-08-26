<?php //declare(strict_types=1);
namespace pvv\side\social;

use \pvv\side\Activity;
use \DateTimeImmutable;
use \DateInterval;

class AnimekveldActivity implements Activity {

	public function nextDate(DateTimeImmutable $date) {
		if ($date->format('H') > 20 || $date->format('H') == 19 && $date->format('i') > 30)
			return $this->nextDate($date->add(new DateInterval('P1D'))->setTime(19, 30, 0));
		$date = $date->setTime(19, 30, 0);
		if ($date->format('N') != 5)
			return $this->nextDate($date->add(new DateInterval('P1D')));
		return $date;
	}

	public function prevDate(DateTimeImmutable $date) {
		if ($date->format('H') < 19 || $date->format('H') == 20 && $date->format('i') < 30)
			return $this->prevDate($date->sub(new DateInterval('P1D'))->setTime(19, 30, 0));
		$date = $date->setTime(19, 30, 0);
		if ($date->format('N') != 5)
			return $this->prevDate($date->sub(new DateInterval('P1D')));
		return $date;
	}

	public function getNextEventFrom(DateTimeImmutable $date) /* : Event */ {
		return new AnimekveldEvent($this->nextDate($date));
	}

	public function getPreviousEventFrom(DateTimeImmutable $date) /* : Event */ {
		return new AnimekveldEvent($this->prevDate($date));
	}

}
