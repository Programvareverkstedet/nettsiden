<?php
require_once dirname(__DIR__) . implode(\DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$translation = ['I dag', 'I morgen', 'Denne uka', 'Neste uke', 'Denne måneden', 'Neste måned'];
$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$motdfetcher = new pvv\side\MOTD($pdo);
$motd = $motdfetcher->getMOTD();

$door = new pvv\side\Door($pdo);
$doorEntry = (object) $door->getCurrent();
if ($doorEntry->time < (time() - 60 * 30)) {
  $doorStateText = 'Ingen data fra dørsensor';
} else {
  if ($doorEntry->open) {
    $doorStateText = 'Døren er <b>åpen</b>';
  } else {
    $doorStateText = 'Døren er <b>ikke åpen</b>';
  }
}
$doorTime = date('H:i', $doorEntry->time);
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/style.css?ver=2">
<link rel="stylesheet" href="css/landing.css">
<link rel="stylesheet" href="css/slideshow.css">
<meta name="theme-color" content="#024" />
<title>Programvareverkstedet</title>

<header>Programvare&shy;verk&shy;stedet</header>


<body>
	<nav id="navbar" class="">
		<?php echo navbar(0, ''); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<header class="landing">
	<div id="imageSlideshow">
			<?php  include 'galleri/slideshow.php'; ?>
			<script src="js/slideshow.js"></script>
		</div>
		<div class="info">
			<h2>Velkommen til Programvare&shy;verkstedet</h2>
			<p>Programvareverkstedet (PVV) er en studentorganisasjon ved NTNU som vil skape et miljø for datainteresserte personer tilknyttet universitetet.</p>
			<p>Nåværende og tidligere studenter ved NTNU, samt ansatte ved NTNU og tilstøtende miljø, kan bli medlemmer.</p>
			<ul class="essentials">
				<a class="btn" href="om/"><li>Om PVV</li></a>
				<a class="btn focus" href="paamelding/"><li>Bli medlem!</li></a>
				<a class="btn" href="https://use.mazemap.com/#config=ntnu&v=1&zlevel=2&center=10.406281,63.417093&zoom=19.5&campuses=ntnu&campusid=1&sharepoitype=poi&sharepoi=38159&utm_medium=longurl">Veibeskrivelse</li></a>
				<div id="doorIndicator" class="<?php echo $doorEntry->open ? 'doorIndicator_OPEN' : 'doorIndicator_CLOSED'; ?>" onclick="location.href='/door/graph.html'">
					<p class="doorStateText"><?php echo $doorStateText; ?></p>
					<p class="doorStateTime">(Oppdatert <?php echo $doorTime; ?>)</p>
				</div>
			</ul>
		</div>
	</header>

	<main class="contentsplit">
		<div class="gridr">
			<h2>Kommende aktiviteter</h2>
			<div class="calendar-events">
				<?php $counter1 = 0; ?>
				<?php $counter2 = 0; ?>
				<?php foreach ($agenda->getNextDays() as $period => $events) {
				  if ($events && $counter1 < 3 && $counter2 < 10) {
				    $counter1++; ?>
					<p class="no-chin"><?php echo $translation[$period]; ?></p>
					<hr>
					<ul>
						<?php foreach ($events as $event) {
						  $counter2++; ?>
							<li>
							<?php if ($event->getURL()) { ?>
								<a href="<?php echo htmlspecialchars($event->getURL()); ?>"><?php echo $event->getName(); ?></a>
							<?php } else { ?>
								<strong><?php echo $event->getName(); ?></strong>
							<?php } ?>

                            <span class="datetime">
                            <?php if ($period !== pvv\side\Agenda::TODAY) {
                              echo $event->getStart()->format('H:i') . ' ';
                              if (pvv\side\Agenda::isThisWeek($event->getStart()) || $event->getStart()->sub(new DateInterval('P3D'))->getTimestamp() < time()) {
                                echo $event->getStart()->format('D');
                              } else {
                                echo $event->getStart()->format('j. F');
                              }
                            } else {
                              echo $event->getStart()->format('H:i');
                            }
                            ?>
                            </span>
						</li>
						<?php } ?>
					</ul>
				<?php
            }
          }
        ?>
			</div>
			<p><a class="btn" href="hendelser/">Flere aktiviteter</a></p>
		</div>

		<div class="gridl">
			<?php
        $title = $motd['title'];

        echo '<h1>';
        if ($title == '') {
          echo 'Dagens melding';
        } else {
          echo $title;
        }
        echo '</h1>';

        $Parsedown = new Parsedown();
        echo $Parsedown->text(implode("\n", $motd['content']));
      ?>
		</div>
	</main>
</body>
</html>
