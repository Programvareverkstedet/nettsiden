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
	const NEXT_WEEK = 3;
	const THIS_MONTH = 4;
	const NEXT_MONTH = 5;

	public function __construct($activities) {
		$this->activities = $activities;
	}

    public static function getFormattedDate($date) {
       return trim(strftime('%A %e. %b %H.%M', $date->getTimeStamp()));
    }

	public function getEventsBetween(DateTimeImmutable $from, DateTimeImmutable $to) {
		$results = [];
		for($i = 0; $i < sizeof($this->activities); $i++) {
			$result = [];
			do {
				$run = false;
				if (sizeof($result)) {
					$date = end($result)->getStop();
				} else {
					$date = $from;
				}
				$next = $this->activities[$i]->getNextEventFrom($date);
				if (isset($next) && $next->getStart() < $to) {
					$result[] = $this->activities[$i]->getNextEventFrom($date);
					$run = true;
				}
			} while ($run);
			$results[] = $result;
		}
		$result = [];
		foreach($results as $a) foreach($a as $b) $result[] = $b;
		usort($result, function($a, $b) {
			return ($a->getStart() < $b->getStart()) ? -1 : 1;
		});
		return $result;
	}

	public function getNextDays() {
		$result = [[], [], [], [], [], []];
		$events = $this->getEventsBetween(
				(new DateTimeImmutable)->sub(new DateInterval('PT1H')), 
				(new DateTimeImmutable)->add(new DateInterval('P1M'))
			);
		foreach ($events as $event) {
			$index = self::NEXT_MONTH;
			if (self::isToday($event->getStart())) $index = self::TODAY;
			elseif (self::isTomorrow($event->getStart())) $index = self::TOMORROW;
			elseif (self::isThisWeek($event->getStart())) $index = self::THIS_WEEK;
			elseif (self::isNextWeek($event->getStart())) $index = self::NEXT_WEEK;
			elseif (self::isThisMonth($event->getStart())) $index = self::THIS_MONTH;
			$result[$index][] = $event;
		}
		return $result;
	}

	public function getNextOfEach(DateTimeImmutable $startDate) {
		$result = array_filter(array_map(
			function($a) use ($startDate){
				return $a->getNextEventFrom($startDate);
			}, $this->activities
		), function($a){return $a;});
		usort($result, function($a, $b) {
			return ($a->getStart()->getTimeStamp() < $b->getStart()->getTimeStamp())
				? -1
				: 1
				;
		});
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

	public static function isNextWeek(DateTimeImmutable $date) {
		return $date->sub(new DateInterval('P7D'))->format('WY') == date('WY');
	}

	public static function isThisMonth(DateTimeImmutable $date) {
		return $date->format('mY') == date('mY');
	}

}
