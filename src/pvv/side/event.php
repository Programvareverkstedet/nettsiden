<?php

declare(strict_types=1);

namespace pvv\side;

use DateTimeImmutable;
use DateInterval;

abstract class Event {
  private DateTimeImmutable $start;

  public function __construct(DateTimeImmutable $start) {
    $this->start = $start;
  }

  public function getStart(): DateTimeImmutable {
    return $this->start;
  }

  public function getRelativeDate(): string {
    if (Agenda::isToday($this->getStart())) {
      return "i dag";
    }
    if (Agenda::isTomorrow($this->getStart())) {
      return "i morgen";
    }
    if (
      Agenda::isThisWeek($this->getStart()) ||
      $this->getStart()->sub(new DateInterval("P4D"))->getTimestamp() < time()
    ) {
      return $this->getStart()->format("l");
    }
    if (Agenda::isNextWeek($this->getStart())) {
      return "neste uke";
    }
    if (Agenda::isThisMonth($this->getStart())) {
      return "denne måneden";
    }

    return $this->getStart()->format("j. F");
  }

  abstract public function getStop(): DateTimeImmutable;

  abstract public function getName(): string;

  abstract public function getLocation(): string;

  abstract public function getOrganiser(): string;

  abstract public function getURL(): string;

  abstract public function getImageURL(): string;

  /*
   * @return string[]
   */
  abstract public function getDescription(): array;

  abstract public function getColor(): string;
}
