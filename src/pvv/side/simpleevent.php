<?php

declare(strict_types=1);

namespace pvv\side;

class SimpleEvent extends Event {
  private $id;
  private $name;
  private $descr;
  private $start;
  private $end;
  private $org;
  private $loc;

  public function __construct($id, $name, \DateTimeImmutable $start, \DateTimeImmutable $end, $org, $loc, $descr, $_isDBEvent = false) {
    $this->id = $id;
    $this->name = $name;
    $this->start = $start;
    $this->end = $end;
    $this->org = $org;
    $this->loc = $loc;
    $this->descr = explode("\n", $descr);
  }

  public function getID() {
    return $this->id;
  }

  public function getStart() {
    return $this->start;
  }

  public function getStop() {
    return $this->end;
  }

  public function getOrganiser() {
    return $this->org;
  }

  public function getLocation() {
    return $this->loc;
  }

  public function getName() {
    return $this->name;
  }

  public function getURL() {
    return '/hendelser/info.php?id=' . $this->id;
  }

  public function getImageURL(): void {}

  public function getDescription() {
    return $this->descr;
  }

  public function getColor() {
    return '#3b7';
  }
}
