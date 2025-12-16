<?php

declare(strict_types=1);

namespace pvv\side\social;

use DateTimeImmutable;
use pvv\side\Activity;

class HackekveldActivity implements Activity {
  public function nextDate(\DateTimeImmutable $date): DateTimeImmutable {
    if (intval($date->format('H')) > 18 || intval($date->format('H')) === 17 && intval($date->format('i')) > 30) {
      return $this->nextDate($date->add(new \DateInterval('P1D'))->setTime(18, 15, 0));
    }
    $date = $date->setTime(16, 15, 0);
    if (intval($date->format('N')) !== 6) {
      return $this->nextDate($date->add(new \DateInterval('P1D')));
    }
    if (intval($date->format('W')) % 2) {
      return $this->nextDate($date->add(new \DateInterval('P7D')));
    }

    return $date;
  }

  public function prevDate(\DateTimeImmutable $date): DateTimeImmutable {
    if (intval($date->format('H')) < 17 || intval($date->format('H')) === 18 && intval($date->format('i')) < 30) {
      return $this->prevDate($date->sub(new \DateInterval('P1D'))->setTime(18, 15, 0));
    }
    $date = $date->setTime(18, 15, 0);
    if (intval($date->format('N')) !== 6) {
      return $this->prevDate($date->sub(new \DateInterval('P1D')));
    }
    if (intval($date->format('W')) % 2) {
      return $this->prevDate($date->sub(new \DateInterval('P7D')));
    }

    return $date;
  }

  public function getNextEventFrom(\DateTimeImmutable $date): HackekveldEvent {
    return new HackekveldEvent($this->nextDate($date));
  }

  public function getPreviousEventFrom(\DateTimeImmutable $date): HackekveldEvent {
    return new HackekveldEvent($this->prevDate($date));
  }
}
