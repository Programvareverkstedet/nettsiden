<?php //declare(strict_types=1);
namespace pvv\side;

use \DateTimeImmutable;

interface RepeatingActivity extends Activity {

	public function getNextEventFrom(DateTimeImmutable $date) /* : Event */;

	public function getPreviousEventFrom(DateTimeImmutable $date) /* : Event */;

}
