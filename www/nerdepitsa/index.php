<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);
use \pvv\side\Agenda;
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/nav.css">
<link rel="stylesheet" href="../css/events.css">
<style>
#outDatedBanner {
	width: 100%;
	height: 100px;
	background-color: lightgray;
	margin: auto auto;
	border: 1px solid salmon;
	border-radius: 20px;
}
#outDatedBanner > p {
	margin: auto auto;
	text-align: center;
}
</style>
<meta name="theme-color" content="#024" />
<title>Sosialverkstedet</title>

<header>Sosial&shy;verk&shy;stedet</header>


<main>
<div id="outDatedBanner"><p><br>Denne siden er trolig utdatert! Hvis du er interessert, ta kontakt i discord-kanalen. <br> This page is probably outdated! If you're interested, check in with someone in our discord-channel. </p></div>
<?php
$activity = new \pvv\side\social\NerdepitsaActivity;
$nextEvent = $activity->getNextEventFrom(new DateTimeImmutable);
?>

<article>
	<h2><em><?= $nextEvent->getRelativeDate()?></em> Nerdepitsa
		<?php if ($nextEvent->getImageURL()) { ?>
		<img src="<?= $nextEvent->getImageURL() ?>">
		<?php } ?>
	</h2>
	<ul class="subtext">
		<li>Tid:
		<strong>
			<?= Agenda::getFormattedDate($nextEvent->getStart());?>
		</strong>
		<li>Sted:
		<strong>
			<?= $nextEvent->getLocation();?>
		</strong>
		<li>Arrangør:
		<strong>
			<?= $nextEvent->getOrganiser();?>
		</strong>
	</ul>

	<?php
	$Parsedown = new Parsedown();
	echo $Parsedown->text(implode("\n", $nextEvent->getDescription()));
	?>
</article>

</main>

<nav>
	<?= navbar(1, 'aktiviteter'); ?>
	<?= loginbar($sp, $pdo); ?>
</nav>
