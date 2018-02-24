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

	public function getImageURL() {
		return '/sosiale/nerdepitsa.jpg';
	}

	public function getDescription() {
		return [
			'<p>Hei, har du lyst til å bli med på pizzaspising på Peppes i Kjøpmannsgata annenhver fredag klokken 19.00?',

			'<p>Vi er en gjeng hvis eneste gjennomgående fellestrekk er en viss interesse for data, samt at vi har eller har hatt en tilknytning til studentmiljøet ved NTNU. For å treffe andre som også faller inn under disse kriteriene treffes vi over pizza på Peppes annenhver fredag. (Definisjon: En fredag er annenhver dersom den ligger i en partallsuke). Vi har reservasjon under navnet Christensen.',

			'<p>Det er ikke noe krav at du er nerd ... noen av oss virker faktisk nesten normale. Det er heller ikke noe krav at du kjenner noen fra før. Det er ikke engang et krav at du må like pizza (selv om det hjelper). Dersom du har lyst til å treffe personer fra datamiljøet ved NTNU så still opp, vi biter ikke (vel, bortsett fra pizzaen da ...)',

			'<p>Strategien er at vi bestiller så mye pizza som vi i fellesskap klarer å stappe ned, for deretter splitte pizza-regningen broderlig; mens hver enkelt betaler for sin egen drikke, dessert mm. '
			];
	}

	public function getColor() {
		return "#c35";
	}

}
