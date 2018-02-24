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
		return "Koserommet";
	}

	public function getOrganiser() /* : User */ {
		return "Liang Zhu";
	}

	public function getURL() /* : string */ {
		return '/anime/';
	}

	public function getImageURL() {
		return '/sosiale/animekveld.jpg';
	}

	public function getDescription() {
		return [
			'Er du glad i japansk tegnefilm eller er du bare nysgjerrige på hva anime er?',
			'Bli med oss! Hver fredag finner vi de nyeste episodene for sesongen.',
			'Vi viser denne senongens nye animeer.',
			'',
			'Alle kan være med på å anbefale eller veto serier.'
			];
	}

	public function getColor() {
		return "#35a";
	}

}
