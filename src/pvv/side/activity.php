<?php //declare(strict_types=1);
namespace pvv\side;

use \DateTimeImmutable;

interface Activity {

	public function getName(); /* : string */

	public function getLocation(); /* : Location */

	public function getOrganiser(); /* : User */

}
