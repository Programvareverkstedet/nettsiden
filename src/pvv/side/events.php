<?php
namespace pvv\side;

Class Events {
    public function getAllEvents(){
	$events = array();
	$ev = new OnceEvent("Test","Now","Never","sm0xe","Here");
	$events[0] = $ev;
	return $events;
    }
}

?>
