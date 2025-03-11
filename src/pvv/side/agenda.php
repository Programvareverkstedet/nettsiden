<?php

declare(strict_types=1);

namespace pvv\side;

class Agenda {
  private $activities;

  public const TODAY = 0;
  public const TOMORROW = 1;
  public const THIS_WEEK = 2;
  public const NEXT_WEEK = 3;
  public const THIS_MONTH = 4;
  public const NEXT_MONTH = 5;

  public function __construct($activities) {
    $this->activities = $activities;
  }

  public static function getFormattedDate($date) {
    return $date->format('l j. M H.i');
  }

  public function getEventsBetween(\DateTimeImmutable $from, \DateTimeImmutable $to) {
    $results = [];
    for ($i = 0; $i < \count($this->activities); ++$i) {
      $result = [];
      do {
        $run = false;
        if (\count($result)) {
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
    foreach ($results as $a) {
      foreach ($a as $b) {
        $result[] = $b;
      }
    }
    usort($result, static fn($a, $b) => ($a->getStart() < $b->getStart()) ? -1 : 1);

    return $result;
  }

  public function getNextDays() {
    $result = [[], [], [], [], [], []];
    $events = $this->getEventsBetween(
      (new \DateTimeImmutable())->setTime(0, 0),
      (new \DateTimeImmutable())->setTime(23, 59)->add(new \DateInterval('P1M'))
    );
    foreach ($events as $event) {
      $index = self::NEXT_MONTH;
      if (self::isToday($event->getStart())) {
        $index = self::TODAY;
      } elseif (self::isTomorrow($event->getStart())) {
        $index = self::TOMORROW;
      } elseif (self::isThisWeek($event->getStart())) {
        $index = self::THIS_WEEK;
      } elseif (self::isNextWeek($event->getStart())) {
        $index = self::NEXT_WEEK;
      } elseif (self::isThisMonth($event->getStart())) {
        $index = self::THIS_MONTH;
      }
      $result[$index][] = $event;
    }

    return $result;
  }

  public function getNextOfEach(\DateTimeImmutable $startDate) {
    $result = array_filter(array_map(
      static fn($a) => $a->getNextEventFrom($startDate),
      $this->activities
    ), static fn($a) => isset($a));
    usort(
      $result,
      static fn($a, $b) => ($a->getStart()->getTimeStamp() < $b->getStart()->getTimeStamp())
            ? -1
            : 1
    );

    return $result;
  }

  public static function isToday(\DateTimeImmutable $date) {
    return $date->format('dmY') == date('dmY');
  }

  public static function isTomorrow(\DateTimeImmutable $date) {
    return $date->sub(new \DateInterval('P1D'))->format('dmY') == date('dmY');
  }

  public static function isThisWeek(\DateTimeImmutable $date) {
    return $date->format('WY') == date('WY');
  }

  public static function isNextWeek(\DateTimeImmutable $date) {
    return $date->sub(new \DateInterval('P7D'))->format('WY') == date('WY');
  }

  public static function isThisMonth(\DateTimeImmutable $date) {
    return $date->format('mY') == date('mY');
  }
}
