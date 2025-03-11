<?php

declare(strict_types=1);

namespace pvv\side;

use DateTimeImmutable;

abstract class Event {
  private $start;

  public function __construct(\DateTimeImmutable $start) {
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
    if (Agenda::isThisWeek($this->getStart()) || $this->getStart()->sub(new \DateInterval('P4D'))->getTimestamp() < time()) {
      return $this->getStart()->format('l');
    }
    if (Agenda::isNextWeek($this->getStart())) {
      return 'neste uke';
    }
    if (Agenda::isThisMonth($this->getStart())) {
      return 'denne måneden';
    }

    return $this->getStart()->format('j. F');
  }

  abstract public function getStop(); /* : DateTimeImmutable */

  abstract public function getName();

  abstract public function getLocation();

  abstract public function getOrganiser();

  abstract public function getURL(); /* : string */

  abstract public function getImageURL(); /* : string */

  abstract public function getDescription(); /* : string */

  abstract public function getColor(); /* : string */
}
