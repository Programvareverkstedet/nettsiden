<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$projectID = 0;
if(isset($_GET['id'])){
	$projectID = $_GET['id'];
}else{
	echo 'No project ID provided';
	exit();
}

require_once(__DIR__ . '/../../vendor/simplesamlphp/simplesamlphp/lib/_autoload.php');
$as = new \SimpleSAML\Auth\Simple('default-sp');
$attrs = $as->getAttributes();

$projectManager = new \pvv\side\ProjectManager($pdo);
$project = $projectManager->getByID($projectID);
if (!$project) {
	echo ":^)";
	exit();
}

$members = $projectManager->getProjectMembers($projectID);
$normal_members = $members;
foreach($normal_members as $i => $data){
	if($data['lead']){
		unset($normal_members[$i]);
	}
}

$is_owner = False;
$is_member = False;
if ($attrs){
	$uname = $attrs['uid'][0];
	foreach($members as $member){
		if ($member['uname'] == $uname){
			if ($member['owner']==1){
				$is_owner = True;
			}
			else if ($member['owner']==0){
				$is_member = True;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" href="../../css/normalize.css">
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/projects.css">
<meta name="theme-color" content="#024" />
<title>Prosjektverkstedet</title>

<header>Prosjekt&shy;verk&shy;stedet</header>


<body>
	<nav>
		<?php echo navbar(2, 'prosjekt'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>

	<main class="contentsplit">
		<div class="gridr">
			<h2><?= $project->getName(); ?></h2>
			<?php
			$Parsedown = new \Parsedown();
			echo $Parsedown->text(implode("\n", $project->getDescription()));
			?>
		</div>

		<div class="gridl">
			<div class="projectmember-container">

			<div class="projectlead">
				<h2>Prosjektledelsen</h2>
				<div class="projectmember">
					<?php foreach($members as $i => $data){
							if($data['lead']){
					?>
							<p><?= $data['name']; ?></p>
							<p class="memberrole"><?= $data['role'] ?></p>
							<p class="memberuname"><?= $data['uname']; ?></p>
							<p class="memberemail"><?= $data['mail']; ?></p>
					<?php }
						} ?>
				</div>
			</div>

			<?php
				if(sizeof($normal_members) > 0){
			?>
				<div class="projectmembers">
					<h2>Medlemmer</h2>
					<?php foreach($normal_members as $i => $data){
					?>
						<div class="projectmember" style="border-color: #6a0;">
							<p><?= $data['name']; ?></p>
							<p class="memberrole"><?= $data['role'] ? $data['role'] : 'Deltaker' ?></p>
							<p class="memberuname"><?= $data['uname']; ?></p>
							<p class="memberemail"><?= $data['mail']; ?></p>
						</div>
					<?php } ?>
				</div>
			<?php
				}

				if(!$is_owner){
			?>

				<form action="update.php", method="post"><p>
					<input type="hidden" name="title" value="derp"/>
					<input type="hidden" name="desc" value="derp"/>
					<input type="hidden" name="active" value="derp"/>
					<input type="hidden" name="id" value="<?= $projectID ?>"/>
					<input type="submit" class="btn" name="join_or_leave" value="<?= ($is_member ? 'Forlat' : 'Bli med!') ?>"></input>
				</p></form>
			<?php
				}
			?>
			</div>
		</div>
	</main>
</body>
