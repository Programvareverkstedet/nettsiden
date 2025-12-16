<?php

declare(strict_types=1);

namespace pvv\side;

class Project {
  private int $id;
  private string $name;
  private array $descr;
  private bool $active;

  public function __construct(
    int $id,
    string $name,
    string $descr,
    bool $active,
  ) {
    $this->id = $id;
    $this->name = $name;
    $this->descr = explode("\n", $descr);
    $this->active = $active;
  }

  public function getID(): int {
    return $this->id;
  }

  public function getName(): string {
    return $this->name;
  }

  public function getDescription(): array {
    return $this->descr;
  }

  public function getActive(): bool {
    return $this->active;
  }
}
