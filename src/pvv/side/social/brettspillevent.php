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
			'<p>Er du en hardcore brettspillentusiast eller en nybegynner som har så vidt spilt ludo?' . "\n" .
			'Da er vår brettspillkveld noe for deg!' . "\n" .
			'Vi tar ut et par spill fra vårt samling of spiller så mye vi orker. Kom innom!',

			'<p><a class="btn" href="#b_spill">Vår samling</a>',
			
			'<div id="b_spill" class="collapsable">' . "\n" .
			'<ul>' . "\n" .
			'<li>Dominion*' . "\n" .
			'<li>Three cheers for master' . "\n" .
			'<li>Avalon' . "\n" .
			'<li>Hanabi' . "\n" .
			'<li>Cards aginst humanity*' . "\n" .
			'<li>Citadels' . "\n" .
			'<li>Munchkin**' . "\n" .
			'<li>Exploding kittens**' . "\n" .
			'<li>Aye dark overlord' . "\n" .
			'<li>Settlers of catan*' . "\n" .
			'<li>Risk**' . "\n" .
			'<li>og mange flere...' . "\n" .
			'</ul>',
			'<p>*  Vi har flere ekspansjoner til spillet',
			'<p>** Vi har flere varianter av spillet',
			'</div>'
			];
	}

}
