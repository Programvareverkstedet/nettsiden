<?php
date_default_timezone_set('Europe/Oslo');
setlocale(LC_ALL, 'no_NO');
require __DIR__ . '/../inc/navbar.php';
require __DIR__ . '/../src/_autoload.php';
require __DIR__ . '/../sql_config.php';

$translation = ['i dag', 'i morgen', 'denne uka', 'neste uke', 'denne måneden', 'neste måned'];
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$agenda = new \pvv\side\Agenda([
		new \pvv\side\social\NerdepitsaActivity,
		new \pvv\side\social\AnimekveldActivity,
		new \pvv\side\DBActivity($pdo),
	]);
?>

<!DOCTYPE html>
<html lang="no">
<head>
	<title>Programvareverkstedet</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/nav.css">
	<link rel="stylesheet" href="css/splash.css">
	<link rel="stylesheet" href="css/landing.css">

	<script>
	function navbar() {
		var x = document.getElementById("navbar");
		if (x.className === "opennav") {
			x.className = "";
		} else {
			x.className = "opennav";
		}
	}
	</script>
</head>

<body>
	<nav id="navbar" class="">
		<?php echo navbar(0, ''); ?>
		<?php echo loginbar(); ?>
	</nav>

	<header>
		<img class="logo" src="css/logo-white.png"/>
		<div class="info">
			<h2>Velkommen til Programvare&shy;verkstedet</h2>
			<p>Programvareverkstedet (PVV) er en studentorganisasjon ved NTNU som vil skape et miljø for datainteresserte personer tilknyttet universitetet.</p>
			<p>Nåværende og tidligere studenter ved NTNU, samt ansatte ved NTNU og tilstøtende miljø, kan bli medlemmer.</p>
			<ul class="essentials">
				<a class="btn" href="om/"><li>Om PVV</li></a>
				<a class="btn join" href="paamelding/"><li>Bli medlem</li></a>
				<a class="btn" href="https://use.mazemap.com/?v=1&amp;left=10.4032&amp;right=10.4044&amp;top=63.4178&amp;bottom=63.4172&amp;campusid=1&amp;zlevel=2&amp;sharepoitype=point&amp;sharepoi=10.40355%2C63.41755%2C2&amp;utm_medium=longurl"><li>Veibeskrivelse</li></a>
			</ul>
		</div>
	</header>

	<main class="contentsplit">
		<div class="gridr">
			<h2>Kommende aktiviteter</h2>
			<div class="calendar-events">
				<?php $counter1 = 0; ?>
				<?php $counter2 = 0; ?>
				<?php foreach($agenda->getNextDays() as $period => $events) if ($events && $counter1 < 3 && $counter2 < 10) { $counter1++ ?>
					<p class="no-chin"><?= $translation[$period] ?></p>
					<hr>
					<ul>
						<?php foreach($events as $event) { $counter2++ ?>
							<li>
							<a href="<?= htmlspecialchars($event->getURL()) ?>"><?= $event->getName(); ?></a>
							<?php /* <a class="icon subscribe">+</a> */ ?>
							<?php if ($period !== \pvv\side\Agenda::TODAY) {
								echo '<span class="time">' . $event->getStart()->format('H:i') . '</span>';
								if (\pvv\side\Agenda::isThisWeek($event->getStart()) || $event->getStart()->sub(new DateInterval('P3D'))->getTimestamp() < time()) {
									echo '<span class="date">' . strftime('%a', $event->getStart()->getTimestamp()) . '</span>';
								} else {
									echo '<span class="date">' . strftime('%e. %b', $event->getStart()->getTimestamp()) . '</span>';
								}
							} else {
								echo '<span class="time">' . $event->getStart()->format('H:i') . '</span>';
							}
							?>
						</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
			<br>
			<p><a class="btn" href="kalender/">Flere aktiviteter</a></p>
		</div>
		
		<div class="gridl">
			<h2>Dagens melding</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Odio tempor orci dapibus ultrices in. Et odio pellentesque diam volutpat commodo. Porttitor leo a diam sollicitudin. Nisl nisi scelerisque eu ultrices. Ipsum dolor sit amet consectetur. Mattis pellentesque id nibh tortor id. Quam adipiscing vitae proin sagittis nisl rhoncus mattis. Integer malesuada nunc vel risus commodo. Curabitur gravida arcu ac tortor dignissim. Mi sit amet mauris commodo quis imperdiet. Enim nulla aliquet porttitor lacus luctus accumsan tortor posuere. Pretium quam vulputate dignissim suspendisse in est. Velit egestas dui id ornare. Urna condimentum mattis pellentesque id nibh tortor id aliquet.<br><br>

Maecenas pharetra convallis posuere morbi leo urna molestie. Egestas sed sed risus pretium. At erat pellentesque adipiscing commodo elit. Ut tortor pretium viverra suspendisse potenti nullam ac. Sit amet volutpat consequat mauris nunc congue nisi vitae suscipit. Faucibus purus in massa tempor nec feugiat nisl. Viverra tellus in hac habitasse platea dictumst vestibulum. Tincidunt vitae semper quis lectus nulla at. Id consectetur purus ut faucibus. Ultricies integer quis auctor elit sed vulputate. Suscipit adipiscing bibendum est ultricies integer quis auctor elit.<br><br>

Nulla malesuada pellentesque elit eget. Odio tempor orci dapibus ultrices in iaculis nunc. Iaculis at erat pellentesque adipiscing. Volutpat ac tincidunt vitae semper. Posuere ac ut consequat semper viverra nam libero justo. Enim tortor at auctor urna nunc id cursus metus. Sit amet cursus sit amet. Eu non diam phasellus vestibulum lorem sed risus. Consequat interdum varius sit amet mattis vulputate enim nulla aliquet. Enim sed faucibus turpis in eu mi bibendum. Eu consequat ac felis donec et odio pellentesque. Cursus eget nunc scelerisque viverra mauris in aliquam sem. Accumsan in nisl nisi scelerisque eu ultrices vitae auctor eu. Quis commodo odio aenean sed adipiscing. Et ultrices neque ornare aenean euismod elementum nisi. Turpis in eu mi bibendum neque egestas congue. Sed arcu non odio euismod. Risus quis varius quam quisque.<br><br>

Consequat interdum varius sit amet mattis vulputate enim nulla. Tristique et egestas quis ipsum suspendisse. Amet massa vitae tortor condimentum lacinia quis vel eros donec. Varius vel pharetra vel turpis nunc eget. Convallis posuere morbi leo urna molestie at elementum eu facilisis. Congue eu consequat ac felis donec et odio pellentesque. Nunc sed velit dignissim sodales ut eu sem integer. Mattis enim ut tellus elementum sagittis. Molestie ac feugiat sed lectus. Cursus vitae congue mauris rhoncus aenean vel elit. Mauris augue neque gravida in. Velit sed ullamcorper morbi tincidunt ornare massa eget egestas purus. Et tortor at risus viverra adipiscing at in tellus integer.</p>
		</div>
	</main>
</body>
</html>