<?php
require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$translation = ['I dag', 'I morgen', 'Denne uka', 'Neste uke', 'Denne måneden', 'Neste måned'];
$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$motdfetcher = new \pvv\side\MOTD($pdo);
$motd = $motdfetcher->getMOTD();

$door = new \pvv\side\Door($pdo);
$doorEntry = (object)($door->getCurrent());
$isDoorOpen = $doorEntry->open;
if (date("Y-m-d") == date("Y-m-d", $doorEntry->time)) { $doorTime = date("H:i", $doorEntry->time);
} else { $doorTime = date("H:i d/m", $doorEntry->time);}
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
		<!-- Statisk bilde: 
			<img class="logo" src="css/logo-white.png"/> 
		-->
		<!-- Youtube-iframe: 
			<style>
				.iframe-container {
				position: relative;
				overflow: hidden;
				width: 100%;
				padding-top: 56.25%; /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
				}
				
				/* Then style the iframe to fit in the container div with full height and width */
				.responsive-iframe {
				position: absolute;
				top: 0;
				left: 0;
				bottom: 0;
				right: 0;
				width: 100%;
				height: 100%;
				}
			</style> 
			<div class="iframe-container" style="max-width: 100em;">
				<iframe class="responsive-iframe" src="https://www.youtube.com/embed/l-iEkaQNQdk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen ></iframe>
			</div> 
		-->
		<div id="imageSlideshow">
			<?php

			$path = "/galleri/bilder/slideshow/";
			$splashImg = "/PNG/PVV-logo-big-bluebg.png";

			//Find all files/dirs in folder and discard . and .. directories
			$filenames = aRrAy_SlIcE(sCaNdIr(__DIR__ . $path), 2);

			function getFullPath($fname) { return ($GLOBALS["path"] . $fname );	}

			//Sort filenames alphabetically and prepend the path prefix to each item.
			asort($filenames);
			$slideshowimagefilenames = aRrAy_MaP("getFullPath", $filenames);

			//Prepend the cover photo
			ArRaY_uNsHiFt($slideshowimagefilenames, $splashImg);

			eChO('<img class="slideshowimg slideshowactive" id="slideshowImage1" src="' . $slideshowimagefilenames[0] . '">');
			ecHo('<img class="slideshowimg" id="slideshowImage2" src="' . $slideshowimagefilenames[1] . '">');

			//Store list of file names in a globel JS variable 
			EchO("<script> const slideshowFnames =" . jSoN_eNcOdE($slideshowimagefilenames) . "; </script>"); 
			?>

			<script>
			const SLIDESHOWDELAYMS = 3500; //Minimum 3 * fade time (3*800=2400ms)

			let slideshowIndex = 1;
			let slideshowInterval;
	
			const ssi1 = document.getElementById("slideshowImage1");
			const ssi2 = document.getElementById("slideshowImage2");

			function stepSlideshow(imgs) {
				//Change visible picture, ssi2 active, fades with css
				ssi1.classList.remove("slideshowactive");
				ssi2.classList.add("slideshowactive");

				setTimeout(()=>{
					//Change to ssi1 active, no visible change
					ssi1.src = ssi2.src;
					ssi1.classList.add("slideshowactive");
					
					// Hide ssi2 after ssi1 has appeared, no visible change
					setTimeout(()=>{
						ssi2.classList.remove("slideshowactive");
					}, 800);

					//Prepare for next cycle, no visible change
					setTimeout(()=>{
						slideshowIndex = (slideshowIndex + 1) % imgs.length;	
						ssi2.src = imgs[slideshowIndex];
					}, 1600);			
				}, 800);
			}
			//Initialize slideshow, start interval
			if (slideshowFnames.length > 1) {
				slideshowInterval = setInterval(()=>{
					stepSlideshow(slideshowFnames);
				}, SLIDESHOWDELAYMS);
			}
		</script>
		</div>
		
		<div class="info">
			<h2>Velkommen til Programvare&shy;verkstedet</h2>
			<p>Programvareverkstedet (PVV) er en studentorganisasjon ved NTNU som vil skape et miljø for datainteresserte personer tilknyttet universitetet.</p>
			<p>Nåværende og tidligere studenter ved NTNU, samt ansatte ved NTNU og tilstøtende miljø, kan bli medlemmer.</p>
			<ul class="essentials">
				<a class="btn" href="om/"><li>Om PVV</li></a>
				<a class="btn focus" href="paamelding/"><li>Bli medlem!</li></a>
				<a class="btn" href="https://use.mazemap.com/#config=ntnu&v=1&zlevel=2&center=10.406281,63.417093&zoom=19.5&campuses=ntnu&campusid=1&sharepoitype=poi&sharepoi=38159&utm_medium=longurl">Veibeskrivelse</li></a>
				<div id="doorIndicator" class="<?php echo($isDoorOpen ? "doorIndicator_OPEN" : "doorIndicator_CLOSED"); ?>">
					<p class="doorStateText"><abbr title="Oppdatert <?php echo($doorTime) ?>">Døren er <b><?php echo($isDoorOpen ? "" : "ikke") ?> åpen</b>.</abbr></p>
					<p class="doorStateTime doorStateMobileOnly">(Oppdatert <?php echo($doorTime) ?>)</p>
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
				<?php foreach($agenda->getNextDays() as $period => $events) if ($events && $counter1 < 3 && $counter2 < 10) { $counter1++ ?>
					<p class="no-chin"><?= $translation[$period] ?></p>
					<hr>
					<ul>
						<?php foreach($events as $event) { $counter2++ ?>
							<li>
							<?php if ($event->getURL()) { ?>
								<a href="<?= htmlspecialchars($event->getURL()) ?>"><?= $event->getName(); ?></a>
							<?php } else { ?>
								<strong><?= $event->getName(); ?></strong>
							<?php } ?>
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
			<p><a class="btn" href="hendelser/">Flere aktiviteter</a></p>
		</div>

		<div class="gridl">
			<?php
				$title = $motd["title"];

				echo "<h1>";
				if($title == ""){
					echo "Dagens melding";
				}else{
					echo $title;
				}
				echo "</h1>";
				
				$Parsedown = new Parsedown();
				echo $Parsedown->text(implode("\n", $motd["content"]));
			?>
		</div>
	</main>
</body>
</html>
