<?php
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userManager = new \pvv\admin\UserManager($pdo);

$as = new SimpleSAML_Auth_Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$uname = $attrs['uid'][0];

if(!$uname){
	header('Content-Type: text/plain', true, 403);
	echo "Du må være logget inn for å se bildegalleriet.\r\n";
	exit();
}


$unamefile = __DIR__ . '/usernames.txt';
$unamepairs = file($unamefile);

$relativePath = "/bilder/pvv-photos/";
$fullPath = getcwd() . $relativePath;

function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            //$results[] = str_replace($GLOBALS["fullPath"], "", $path); // Works, but breaks if the image path contains the path to the gallery on the server
            //Remove the full path to the gallery from the image path. Keep username and path to image.
            $pos = strpos($path, $GLOBALS["fullPath"]);
            if ($pos !== false) {
                $cleanPath = substr_replace($path, "", $pos, strlen($GLOBALS["fullPath"]));
            }
            $results[] = $cleanPath;
        } else if ($value != "." && $value != "..") {
            //recursively scan directories
            getDirContents($path, $results);
        }
    }
    return $results;
}
$images = getDirContents($fullPath);

$imageTemplate = '
<div class="card is-flex is-flex-direction-column is-justify-content-space-between gallery-img-card">
    <div class="card-image">
        <figure class="image">
            <img src="%path" alt="%name" class="card-image">
        </figure>
    </div>
    <div class="card-content">
        <div class="media">
            <div class="media-content">
                <p class="title is-4">%realname</p>
                <p class="subtitle is-6">%user</p>
            </div>
        </div>
        <div class="content">
            %name
            <br>
            <time datetime="%time">%time</time>
            </div>
        </div>
    </div>
</div>
';


?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/events.css">
    <link rel="stylesheet" href="../css/gallery.css">
    <link rel="stylesheet" href="../css/bulma.min.css">
    <meta name="theme-color" content="#024" />
    <title>Fotoverkstedet</title>
</head>
<body>
    <header>Fotoverkstedet</header>
    <nav id="navbar" class="">
		<?php echo navbar(0, ''); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>
    <main class="card gallery-container">
        <?php
        foreach ($images as $key => $value) {
            $modTime = date("d.m.Y H:i", filemtime($fullPath . $value));
            $imguser = explode("/", $value)[0];
            $displaypath = substr($value, strpos($value, "/")+1);
            $realname = "Ukjent";
            foreach ($unamepairs as $unamepair) {
                $unamepair = explode(":", $unamepair);
                if ($unamepair[0] == $imguser) {
                    $realname = $unamepair[1];
                    break;
                }
            }

            $vars = [
                "%user" =>  $imguser,
                "%time" =>  $modTime,
                "%name" =>  $displaypath,
                "%path" =>  "/galleri/" . $relativePath .$value,
                "%realname" =>  $realname
            ];
            echo strtr($imageTemplate, $vars);
        }
        ?>
    </main>
</body>
</html>
