<?php declare(strict_types=1);
namespace pvv\side;

use \DateTime;

interface RepeatingActivity extends Activity {

	public function getNextEventFrom(DateTime $date) /* : Event */;

	public function getPreviousEventFrom(DateTime $date) /* : Event */;

}
