<?php

declare(strict_types=1);

namespace pvv\side;

use pvv\side\Event;

interface Activity {
  public function getNextEventFrom(\DateTimeImmutable $date): ?Event;

  public function getPreviousEventFrom(\DateTimeImmutable $date): ?Event;
}
