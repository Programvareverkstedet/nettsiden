<?php

declare(strict_types=1);

namespace pvv\side\social;

use DateTimeImmutable;
use pvv\side\Event;

class HackekveldEvent extends Event {
  public function getStop(): DateTimeImmutable {
    return $this->getStart()->add(new \DateInterval('PT4H1800S'));
  }

  public function getName(): string {
    return 'Hackekveld';
  }

  public function getLocation(): string {
    return 'Terminalrommet / Discord / IRC';
  }

  public function getOrganiser(): string {
    return 'PVV';
  }

  public function getURL(): string {
    return '#';
  }

  public function getImageURL(): string {
    return '/pvv-logo.png';
  }

  public function getDescription(): array {
    return [
      'Mange PVV-medlemmer liker å programmere.',
      'Hvis du også liker å programmere, så bli med! Her kan du jobbe med dine egne prosjekter eller starte noe med andre nerder her på huset. Vi møtes for en hyggelig prat, mye god programmering og delsponset pizza.',
    ];
  }

  public function getColor(): string {
    return '#35a';
  }
}
