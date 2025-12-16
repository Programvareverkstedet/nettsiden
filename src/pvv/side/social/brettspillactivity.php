<?php

declare(strict_types=1);

namespace pvv\side\social;

use pvv\side\Activity;

class BrettspillActivity implements Activity {
  public function nextDate(\DateTimeImmutable $date): \DateTimeImmutable {
    if (
      intval($date->format("H")) > 17 ||
      (intval($date->format("H")) === 16 && intval($date->format("i")) > 15)
    ) {
      return $this->nextDate(
        $date->add(new \DateInterval("P1D"))->setTime(16, 15, 0),
      );
    }
    $date = $date->setTime(16, 15, 0);
    if (intval($date->format("N")) !== 7) {
      return $this->nextDate($date->add(new \DateInterval("P1D")));
    }
    if ((intval($date->format("W")) % 2) - 1) {
      return $this->nextDate($date->add(new \DateInterval("P7D")));
    }

    return $date;
  }

  public function prevDate(\DateTimeImmutable $date): \DateTimeImmutable {
    if (
      intval($date->format("H")) < 16 ||
      (intval($date->format("H")) === 17 && intval($date->format("i")) < 15)
    ) {
      return $this->prevDate(
        $date->sub(new \DateInterval("P1D"))->setTime(16, 15, 0),
      );
    }
    $date = $date->setTime(16, 15, 0);
    if (intval($date->format("N")) !== 7) {
      return $this->prevDate($date->sub(new \DateInterval("P1D")));
    }
    if ((intval($date->format("W")) % 2) - 1) {
      return $this->prevDate($date->sub(new \DateInterval("P7D")));
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
