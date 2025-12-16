<?php

declare(strict_types=1);

namespace pvv\side\social;

use DateTimeImmutable;
use pvv\side\Event;

class DriftkveldEvent extends Event {
  public function getStop(): DateTimeImmutable {
    return $this->getStart()->add(new \DateInterval('PT4H1800S'));
  }

  public function getName(): string {
    return 'Driftkveld';
  }

  public function getLocation(): string {
    return 'Terminalrommet / Discord / IRC';
  }

  public function getOrganiser(): string {
    return 'Torstein Nordgård-Hansen';
  }

  public function getURL(): string {
    return '/driftkveld/';
  }

  public function getImageURL(): string {
    return '/sosiale/drift.jpg';
  }

  public function getDescription(): array {
    return [
      'Vil du drifte?',
      'Vil du være kul kis TM?',
      'Kom på driftkveld!',
      '',
      'Vi møtes annenhver uke for å ta unna driftarbeid og drikke kaffe.',
      'Alle PVVere er velkommene, enten de er erfarne driftere eller helt utenforstående!',
    ];
  }

  public function getColor(): string {
    return '#35a';
  }
}
