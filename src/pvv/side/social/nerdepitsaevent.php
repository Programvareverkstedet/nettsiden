<?php //declare(strict_types=1);
namespace pvv\side\social;

use \pvv\side\Event;

use \DateInterval;

class NerdepitsaEvent extends Event {

	public function getStop() {
		return $this->getStart()->add(new DateInterval('PT2H1800S'));
	}

	public function getName() {
		return "Nerdepitsa";
	}

	public function getLocation() /* : Location */ {
		return "Peppes Kjøpmansgata";
	}

	public function getOrganiser() /* : User */ {
		return "Anders Christensen";
	}

	public function getURL() /* : string */ {
		return '/nerdepitsa/';
	}

}
