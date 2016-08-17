<?php //declare(strict_types=1);
namespace pvv\side\social;

use \pvv\side\Event;

use \DateInterval;

class AnimekveldEvent extends Event {

	public function getStop() {
		return $this->getStart()->add(new DateInterval('PT4H1800S'));
	}

	public function getName() /* : string */ {
		return "Animekveld";
	}

	public function getLocation() /* : Location */ {
		return "Peppes Kjøpmansgata";
	}

	public function getOrganiser() /* : User */ {
		return "Anders Christensen";
	}

}
