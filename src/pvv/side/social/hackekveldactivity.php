<?php

declare(strict_types=1);

namespace pvv\side\social;

use pvv\side\Activity;

class HackekveldActivity implements Activity {
  public function nextDate(\DateTimeImmutable $date) {
    if ($date->format('H') > 18 || $date->format('H') == 17 && $date->format('i') > 30) {
      return $this->nextDate($date->add(new \DateInterval('P1D'))->setTime(18, 15, 0));
    }
    $date = $date->setTime(16, 15, 0);
    if ($date->format('N') != 6) {
      return $this->nextDate($date->add(new \DateInterval('P1D')));
    }
    if ($date->format('W') % 2) {
      return $this->nextDate($date->add(new \DateInterval('P7D')));
    }

    return $date;
  }

  public function prevDate(\DateTimeImmutable $date) {
    if ($date->format('H') < 17 || $date->format('H') == 18 && $date->format('i') < 30) {
      return $this->prevDate($date->sub(new \DateInterval('P1D'))->setTime(18, 15, 0));
    }
    $date = $date->setTime(18, 15, 0);
    if ($date->format('N') != 6) {
      return $this->prevDate($date->sub(new \DateInterval('P1D')));
    }
    if ($date->format('W') % 2) {
      return $this->prevDate($date->sub(new \DateInterval('P7D')));
    }

    return $date;
  }

  public function getNextEventFrom(\DateTimeImmutable $date) { /* : Event */
    return new HackekveldEvent($this->nextDate($date));
  }

  public function getPreviousEventFrom(\DateTimeImmutable $date) { /* : Event */
    return new HackekveldEvent($this->prevDate($date));
  }
}
