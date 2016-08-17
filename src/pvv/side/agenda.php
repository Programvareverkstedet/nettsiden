<?php //declare(strict_types=1);
namespace pvv\side;

use \pvv\side\social\NerdepitsaActivity;
use \pvv\side\social\AnimekveldActivity;

use \DateTimeImmutable;
use \DateInterval;

class Agenda {

	const TODAY = 0;
	const TOMORROW = 1;
	const THIS_WEEK = 2;
	const THIS_MONTH = 3;
	const NEXT_MONTH = 4;

	public function __construct() {
		$this->activities = [
			new NerdepitsaActivity,
			new AnimekveldActivity,
		];
	}

	public function getEventsBetween(DateTimeImmutable $from, DateTimeImmutable $to) {
		$results = [[], []];
		do {
			$run = false;
			for($i = 0; $i < sizeof($this->activities); $i++) {
				if (sizeof($results[$i])) {
					$date = end($results[$i])->getStop();
				} else {
					$date = $from;
				}
				$next = $this->activities[$i]->getNextEventFrom($date);
				if (isset($next) && $next->getStart() < $to) {
					$results[$i][] = $this->activities[$i]->getNextEventFrom($date);
					$run = true;
				}
			}
		} while ($run);
		$result = [];
		foreach($results as $a) foreach($a as $b) $result[] = $b;
		usort($result, function($a, $b) {
			return ($a->getStart() < $b->getStart()) ? -1 : 1;
		});
		return $result;
	}

	public function getNextDays() {
		$result = [[], [], [], [], []];
		$events = $this->getEventsBetween(
				(new DateTimeImmutable)->sub(new DateInterval('PT1H')), 
				(new DateTimeImmutable)->add(new DateInterval('P1M'))
			);
		foreach ($events as $event) {
			$index = self::NEXT_MONTH;
			if (self::isToday($event->getStart())) $index = self::TODAY;
			elseif (self::isTomorrow($event->getStart())) $index = self::TOMORROW;
			elseif (self::isThisWeek($event->getStart())) $index = self::THIS_WEEK;
			elseif (self::isThisMonth($event->getStart())) $index = self::THIS_MONTH;
			$result[$index][] = $event;
		}
		return $result;
	}

	public static function isToday(DateTimeImmutable $date) {
		return $date->format('dmY') == date('dmY');
	}

	public static function isTomorrow(DateTimeImmutable $date) {
		return $date->sub(new DateInterval('P1D'))->format('dmY') == date('dmY');
	}

	public static function isThisWeek(DateTimeImmutable $date) {
		return $date->format('WY') == date('WY');
	}

	public static function isThisMonth(DateTimeImmutable $date) {
		return $date->format('mY') == date('mY');
	}

}
