<?php

declare(strict_types=1);

namespace pvv\side;

class Project {
  private $id;
  private $name;
  private $descr;
  private $active;

  public function __construct($id, $name, $descr, $active) {
    $this->id = $id;
    $this->name = $name;
    $this->descr = explode("\n", $descr);
    $this->active = $active;
  }

  public function getID() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getDescription() {
    return $this->descr;
  }

  public function getActive() {
    return $this->active;
  }
}
