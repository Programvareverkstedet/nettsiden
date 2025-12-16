<?php

declare(strict_types=1);

namespace pvv\side\social;

use pvv\side\Event;

class NerdepitsaEvent extends Event {
  public function getStop(): \DateTimeImmutable {
    return $this->getStart()->add(new \DateInterval('PT2H1800S'));
  }

  public function getName(): string {
    return 'Nerdepitsa';
  }

  public function getLocation(): string {
    return 'Peppes Kjøpmansgata';
  }

  public function getOrganiser(): string {
    return 'Anders Christensen';
  }

  public function getURL(): string {
    return '/nerdepitsa/';
  }

  public function getImageURL(): string {
    return '/sosiale/nerdepitsa.jpg';
  }

  public function getDescription(): array {
    return [
      'Hei, har du lyst til å bli med på pizzaspising annenhver fredag? Vi møtes på Peppes i Kjøpmannsgata fredag klokken 19.00 hver partallsuke!',
      '',
      'Vi er en trivelig gjeng hvis der fellestrekk er en viss interesse for data, samt har eller har hatt en tilknytning til studentmiljøet ved NTNU. For å treffe andre som også faller inn under disse kriteriene treffes vi over pizza på Peppes annenhver fredag. (Definisjon: En fredag er annenhver dersom den ligger i en partallsuke). Vi har reservasjon under navnet Christensen med storkunderabatt.',
      '',
      'Det er ikke noe krav at du er nerd... noen av oss virker faktisk nesten normale! Det er heller ikke noe krav at du kjenner noen fra før. Det er ikke engang et krav at du må like pizza! (selv om det hjelper) Dersom du har lyst til å treffe personer fra datamiljøet ved NTNU så bare still opp! Vi biter ikke, vel, bortsett fra pizzaen da.',
      '',
      'Vi bestiller så mye pizza som vi i fellesskap klarer å stappe i oss, og splitter dermed pizza-regningen broderlig, mens hver enkelt betaler for sin egen drikke, dessert mm. Vell møtt!',
    ];
  }

  public function getColor(): string {
    return '#c35';
  }
}
