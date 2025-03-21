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
$projects = $projectManager->getByOwner($attrs['uid'][0]);

$page = 1;
if (isset($_GET['page'])) {
  $page = $_GET['page'];
}

$filter = '';
if (isset($_GET['filter'])) {
  $filter = $_GET['filter'];
}

// filter
$projects = array_values(array_filter(
  $projects,
  static fn($project) => (preg_match('/.*' . $filter . '.*/i', $project->getName()) || preg_match('/.*' . $filter . '.*/i', implode(' ', $project->getDescription())))
));
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/events.css">
<link rel="stylesheet" href="../css/admin.css">
<meta name="theme-color" content="#024" />
<title>Prosjektverkstedet</title>

<header>Prosjekt&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(1, 'prosjekt'); ?>
		<?php echo loginbar(); ?>
	</nav>

	<main class="gridsplit">
		<div class="gridl">
			<h2 class="no-chin">Mine Prosjekter</h2>

			<ul class="event-list">
				<?php
          $counter = 0;
          $pageLimit = 8;

          for ($i = ($pageLimit * ($page - 1)); $i < count($projects); ++$i) {
            if ($counter == $pageLimit) {
              break;
            }

            $project = $projects[$i];
            $projectID = $project->getID();

            $owner = $projectManager->getProjectOwner($projectID);
            if ($owner['uname'] != $attrs['uid'][0]) {
              continue;
            }
        ?>

					<li>
						<div class="event">
							<div class="event-info">
								<a href="edit.php?id=<?php echo $project->getID(); ?>">
									<h3 class="no-chin"><?php echo $project->getName(); ?></h3>
								</a>
								<p style="text-decoration: none;"><?php echo implode('<br>', array_slice($project->getDescription(), 0, 4)); ?></p>
							</div>
						</div>
					</li>

				<?php
            ++$counter;
          }
        ?>
			</ul>

			<?php
        if ($page != 1) {
          echo '<a class="btn float-left" href="?page=' . ($page - 1) . '&filter=' . urlencode($filter) . '">Forrige side</a>';
        }

        if (($counter == $pageLimit) && (($pageLimit * $page) < count($projects))) {
          echo '<a class="btn float-right" href="?page=' . ($page + 1) . '&filter=' . urlencode($filter) . '">Neste side</a>';
        }
      ?>
		</div>

		<div class="gridr">
			<h2>Verktøy</h2>
			<a class="btn" href="edit.php?new=1">Lag prosjekt</a>
			<h2>Filter</h2>
			<form action="mine.php" method="get">
				<p class="no-chin">Navn</p>
				<?php echo '<input type="text" name="filter" class="boxinput" value="' . $filter . '">'; ?><br>

				<div style="margin-top: 2em;">
					<input type="submit" class="btn" value="Filtrer"></input>
				</div>
			</form>
		</div>
	</main>
</body>
