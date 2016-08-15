<?php //declare(strict_types=1);
namespace pvv\side;

interface Event extends Activity {

	public function getStart(); /* : DateTime */

	public function getStop(); /* : DateTime */

}
