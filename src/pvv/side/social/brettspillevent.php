<?php //declare(strict_types=1);
namespace pvv\side\social;

use \pvv\side\Event;

use \DateInterval;

class BrettspillEvent extends Event {

	public function getStop() {
		return $this->getStart()->add(new DateInterval('PT4H1800S'));
	}

	public function getName() /* : string */ {
		return "Brettspillkveld";
	}

	public function getLocation() /* : Location */ {
		return "Koserommet";
	}

	public function getOrganiser() /* : User */ {
		return "Robert Maikher";
	}

	public function getURL() /* : string */ {
		return '/brettspill/';
	}

	public function getImageURL() {
		return '/sosiale/brettspill.jpg';
	}

	public function getDescription() {
		return [
			'Er du en hardcore brettspillentusiast eller en nybegynner som har så vidt spilt ludo?'.
			'Da er vår brettspillkveld noe for deg!' .
			'Vi tar ut et par spill fra vårt samling of spiller så mye vi orker. Kom innom!',
			'',
			'## Vår samling',
			'',
			'* Dominion\*',
			'* Three cheers for master',
			'* Avalon',
			'* Hanabi',
			'* Cards aginst humanity\*',
			'* Citadels',
			'* Munchkin\*\*',
			'* Exploding kittens\*\*',
			'* Aye dark overlord',
			'* Settlers of catan\*',
			'* Risk\*\*',
			'* og mange flere...',
			'',
			'\*  Vi har flere ekspansjoner til spillet',
			'',
			'\*\* Vi har flere varianter av spillet',
			];
	}

	public function getColor() {
		return "#000";
	}

}
