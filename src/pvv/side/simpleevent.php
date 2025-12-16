<?php

declare(strict_types=1);

namespace pvv\side;

use DateTimeImmutable;

class SimpleEvent extends Event {
  private int $id;
  private string $name;
  private array $descr;
  private DateTimeImmutable $start;
  private DateTimeImmutable $end;
  private string $org;
  private string $loc;

  public function __construct(
    int $id,
    string $name,
    \DateTimeImmutable $start,
    \DateTimeImmutable $end,
    string $org,
    string $loc,
    string $descr,
    bool $_isDBEvent = false,
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->start = $start;
    $this->end = $end;
    $this->org = $org;
    $this->loc = $loc;
    $this->descr = explode("\n", $descr);
  }

  public function getID(): int {
    return $this->id;
  }

  public function getStart(): DateTimeImmutable {
    return $this->start;
  }

  public function getStop(): DateTimeImmutable {
    return $this->end;
  }

  public function getOrganiser(): string {
    return $this->org;
  }

  public function getLocation(): string {
    return $this->loc;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getURL(): string {
    return "/hendelser/info.php?id=" . $this->id;
  }

  public function getImageURL(): string {
    return "/";
  }

  public function getDescription(): array {
    return $this->descr;
  }

  public function getColor(): string {
    return "#3b7";
  }
}
