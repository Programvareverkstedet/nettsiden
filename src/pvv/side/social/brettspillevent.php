<?php

declare(strict_types=1);

namespace pvv\side\social;

use pvv\side\Event;

class BrettspillEvent extends Event {
  public function getStop(): \DateTimeImmutable {
    return $this->getStart()->add(new \DateInterval('PT4H1800S'));
  }

  public function getName(): string {
    return 'Brettspillkveld';
  }

  public function getLocation(): string {
    return 'Programvareverkstedet';
  }

  public function getOrganiser(): string {
    return 'Programvareverkstedet';
  }

  public function getURL(): string {
    return '/brettspill/';
  }

  public function getImageURL(): string {
    return '/sosiale/brettspill.jpg';
  }

  public function getDescription(): array {
    return [
      'Er du en hardcore brettspillentusiast eller en nybegynner som har så vidt spilt ludo? '
      . 'Da er vår brettspillkveld noe for deg! '
      . 'Vi tar ut et par spill fra vårt samling of spiller så mye vi orker. Kom innom!',
      '',
      '## Vår samling',
      '',
      '* Dominion\\*',
      '* Three cheers for master',
      '* Avalon',
      '* Hanabi',
      '* Cards aginst humanity\\*',
      '* Citadels',
      '* Munchkin\\*\\*',
      '* Exploding kittens\\*\\*',
      '* Aye dark overlord',
      '* Settlers of catan\\*',
      '* Risk\\*\\*',
      '* og mange flere...',
      '',
      '\\*  Vi har flere ekspansjoner til spillet',
      '',
      '\\*\\* Vi har flere varianter av spillet',
    ];
  }

  public function getColor(): string {
    return '#000';
  }
}
