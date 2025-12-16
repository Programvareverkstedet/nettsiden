<?php

declare(strict_types=1);

namespace pvv\side\social;

use DateTimeImmutable;
use pvv\side\Event;

class AnimekveldEvent extends Event {
  public function getStop(): DateTimeImmutable {
    return $this->getStart()->add(new \DateInterval("PT4H1800S"));
  }

  public function getName(): string {
    return "Animekveld";
  }

  public function getLocation(): string {
    /* : Location */
    return "Koserommet";
  }

  public function getOrganiser(): string {
    return "Christoffer Viken";
  }

  public function getURL(): string {
    return "/anime/";
  }

  public function getImageURL(): string {
    return "/sosiale/animekveld.jpg";
  }

  public function getDescription(): array {
    return [
      "Er du glad i japanske tegneserier eller bare nysgjerrig på hva anime er?",
      "Bli med oss hver fredag, der vi finner frem de nyeste episodene for sesongen!",
      "",
      "Alle kan være med på å anbefale eller veto serier.",
      "",
    ];
  }

  public function getColor(): string {
    return "#35a";
  }
}
