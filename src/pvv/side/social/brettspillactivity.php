<?php

declare(strict_types=1);

namespace pvv\side\social;

use pvv\side\Activity;

class BrettspillActivity implements Activity {
  public function nextDate(\DateTimeImmutable $date): \DateTimeImmutable {
    if (
      (int) $date->format('H') > 17
      || ((int) $date->format('H') === 16 && (int) $date->format('i') > 15)
    ) {
      return $this->nextDate(
        $date->add(new \DateInterval('P1D'))->setTime(16, 15, 0),
      );
    }
    $date = $date->setTime(16, 15, 0);
    if ((int) $date->format('N') !== 7) {
      return $this->nextDate($date->add(new \DateInterval('P1D')));
    }
    if (((int) $date->format('W') % 2) - 1) {
      return $this->nextDate($date->add(new \DateInterval('P7D')));
    }

    return $date;
  }

  public function prevDate(\DateTimeImmutable $date): \DateTimeImmutable {
    if (
      (int) $date->format('H') < 16
      || ((int) $date->format('H') === 17 && (int) $date->format('i') < 15)
    ) {
      return $this->prevDate(
        $date->sub(new \DateInterval('P1D'))->setTime(16, 15, 0),
      );
    }
    $date = $date->setTime(16, 15, 0);
    if ((int) $date->format('N') !== 7) {
      return $this->prevDate($date->sub(new \DateInterval('P1D')));
    }
    if (((int) $date->format('W') % 2) - 1) {
      return $this->prevDate($date->sub(new \DateInterval('P7D')));
    }

    return $date;
  }

  public function getNextEventFrom(\DateTimeImmutable $date): BrettspillEvent {
    return new BrettspillEvent($this->nextDate($date));
  }

  public function getPreviousEventFrom(
    \DateTimeImmutable $date,
  ): BrettspillEvent {
    return new BrettspillEvent($this->prevDate($date));
  }
}
