<ul id="ticker">
<?php
{
	require __DIR__ . '/../src/_autoload.php';
	require __DIR__ . '/../config.php';
	$translation = ['i dag', 'i morgen', 'denne uken', 'neste uke', 'denne måneden', 'neste måned'];
	$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$agenda = new \pvv\side\Agenda([
			new \pvv\side\social\NerdepitsaActivity,
			new \pvv\side\social\AnimekveldActivity,
			new \pvv\side\DBActivity($pdo),
		]);
	
	$test = true;
	foreach($agenda->getNextDays() as $period => $events) {
		if (!$events) continue;
		$i = 0;
		$n = count($events);
		foreach($events as $event){
			if ($i == 0){
				echo '<li style="text-align: center;"><span style="text-transform: uppercase;">' . $translation[$period] . '</span>: ';
			} else if ($i < $n-1) {
				echo '<i style="opacity:0.7;">,&nbsp;</i>';
			} else{
				echo '<i style="opacity:0.7;">&nbsp;og&nbsp;</i>';
			}
			echo '<a href="' . $event->getURL() . '">' . $event->getName() . '</a>';
			$i = $i + 1;
		}
		break;
	}
}
?>
</ul>