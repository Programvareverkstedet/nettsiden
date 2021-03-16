<?php //declare(strict_types=1);
namespace pvv\side\social;

use \pvv\side\Event;

use \DateInterval;

class DriftkveldEvent extends Event {

	public function getStop() {
		return $this->getStart()->add(new DateInterval('PT4H1800S'));
	}

	public function getName() /* : string */ {
		return "Driftkveld";
	}

	public function getLocation() /* : Location */ {
		return "Terminalrommet / Discord / IRC";
	}

	public function getOrganiser() /* : User */ {
		return "Torstein Nordgård-Hansen";
	}

	public function getURL() /* : string */ {
		return '/drift/';
	}

	public function getImageURL() {
		return '/sosiale/drift.jpg';
	}

	public function getDescription() {
		return [
			'Vil du drifte?',
			'Vil du være kul kis TM?',
            'Kom på driftkveld!',
            '',
            'Vi møtes en gang i uka for å ta unna driftarbeid og drikke kaffe.',
            'Alle PVVere er velkommene, enten de er erfarne driftere eller helt utenforstående!'
			];
	}

	public function getColor() {
		return "#35a";
	}

}
