<?php
date_default_timezone_set('Europe/Oslo');
setlocale(\LC_ALL, 'nb_NO');
require __DIR__ . '/../../inc/navbar.php';
require __DIR__ . '/../../src/_autoload.php';
require __DIR__ . '/../../config.php';

require_once __DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php';
$as = new SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$projectManager = new pvv\side\ProjectManager($pdo);

$project_is_new = false;
if (isset($_GET['new'])) {
  $project_is_new = $_GET['new'];
}

$projectID = 0;
if (isset($_GET['id'])) {
  $projectID = $_GET['id'];
} elseif (!$project_is_new) {
  echo "\nID not set";
  exit;
}

$project = new pvv\side\Project(
  id: 0,
  title: 'Nytt Prosjekt',
  description_en: null,
  description_no: null,
  gitea_link: null,
  issue_board_link: null,
  wiki_link: null,
  programming_languages: null,
  technologies: null,
  keywords: null,
  license: null,
  logo_url: null
);

if (!$project_is_new) {
  $project = $projectManager->getByID($projectID);
  $maintainers = $projectManager->getProjectMaintainers($projectID);

  if ($owner['uname'] != $attrs['uid'][0]) {
    header('HTTP/1.0 403 Forbidden');
    echo 'wrong user';
    exit;
  }
}

?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/nav.css">
<link rel="stylesheet" href="../css/projects.css">
<meta name="theme-color" content="#024" />
<title>Prosjektverkstedet</title>

<header>Prosjekt&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(1, 'prosjekt'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main>
		<h2>Nytt prosjekt</h2>

		<form action="update.php", method="post">
			<p class="subtitle no-chin">Prosjektnavn</p>
			<p class="subnote">Gi prosjektet ditt et passende navn</p>
			<input class="wide" type="text" name="title" value="<?php echo $project->getTitle(); ?>" class="boxinput" required><br>

			<p class="subtitle no-chin">Beskrivelse (<i style="opacity:0.5;">markdown</i>)</p>
			<p class="subnote no-chin">Hva går prosjektet ditt ut på?</p>
			<p class="subnote">De første to linjene blir vist på prosjektkortet, prøv å gjøre de til et fint sammendrag eller intro!</p>
			<textarea class="tall" name="desc_no" style="width:100%" rows="8" class="boxinput" required><?php echo implode("\n", $project->getDescriptionNo()); ?></textarea>

			<p class="subtitle no-chin">Beskrivelse på engelsk (<i style="opacity:0.5;">markdown</i>)</p>
			<p class="subnote no-chin">Gjenta på engelsk</p>
			<textarea class="tall" name="desc_en" style="width:100%" rows="8" class="boxinput" required><?php echo implode("\n", $project->getDescriptionEn()); ?></textarea>

			<p class="subtitle no-chin">Gitea-link</p>
			<p class="subnote">Link til prosjektet på Gitea</p>
			<input class="wide" type="text" name="gitea" value="<?php echo $project->getGiteaLink(); ?>" class="boxinput"><br>

			<p class="subtitle no-chin">Issue board-link</p>
			<p class="subnote">Link til issue board på Gitea</p>
			<input class="wide" type="text" name="issue" value="<?php echo $project->getIssueBoardLink(); ?>" class="boxinput"><br>

			<p class="subtitle no-chin">Wiki-link</p>
			<p class="subnote">Link til wiki-side</p>
			<input class="wide" type="text" name="wiki" value="<?php echo $project->getWikiLink(); ?>" class="boxinput"><br>

			<p class="subtitle no-chin">Programmeringsspråk</p>
			<p class="subnote">Hvilke programmeringsspråk brukes i prosjektet?</p>
			<input class="wide" type="text" name="langs" value="<?php echo implode("\n", $project->getProgrammingLanguages()); ?>" class="boxinput"><br>

			<p class="subtitle no-chin">Teknologier</p>
			<p class="subnote">Hvilke teknologier brukes i prosjektet?</p>
			<input class="wide" type="text" name="techs" value="<?php echo implode("\n", $project->getTechnologies()); ?>" class="boxinput"><br>

			<p class="subtitle no-chin">Nøkkelord</p>
			<p class="subnote">Nøkkelord som beskriver prosjektet</p>
			<input class="wide" type="text" name="keywords" value="<?php echo implode("\n", $project->getKeywords()); ?>" class="boxinput"><br>

			<p class="subtitle no-chin">Lisens</p>
			<p class="subnote">Hvilken lisens bruker prosjektet?</p>
			<input class="wide" type="text" name="license" value="<?php echo $project->getLicense(); ?>" class="boxinput"><br>

			<p class="subtitle no-chin">Logo-URL</p>
			<p class="subnote">Link til logo for prosjektet</p>
			<input class="wide" type="text" name="logo" value="<?php echo $project->getLogoURL(); ?>" class="boxinput"><br>

			<?php echo '<input type="hidden" name="id" value="' . $project->getID() . '" />'; ?>
			<input type="hidden" name="active" value="1"/>

			<div style="margin-top: 0.2em;">
				<hr class="ruler">
				 <input type="submit" class="btn" value="<?php echo $project_is_new ? 'Opprett prosjekt' : 'Lagre endringer'; ?>"></input>
				 <?php if (!$project_is_new) {?><input type="submit" class="btn" name="delete" value="Slett"></input><?php } ?>
			</div>
		</form>
	</main>
</body>
