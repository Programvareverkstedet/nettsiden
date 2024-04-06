<?php
error_reporting(0);
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$pdo = new \PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userManager = new \pvv\admin\UserManager($pdo);

$as = new \SimpleSAML\Auth\Simple('default-sp');
$as->requireAuth();
$attrs = $as->getAttributes();
$loginname = $attrs['uid'][0];

if(!$loginname) {
	header('Content-Type: text/plain', true, 403);
	echo "Du må være logget inn for å se bildegalleriet.\r\n";
	exit();
}

# Sourced from config.php through include.php
$galleryDir = $GALLERY_DIR;
$serverPath = $GALLERY_SERVER_PATH;

$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
$unamefile = $galleryDir . "/usernames.txt";

$unamepairs = file($unamefile);

function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            //Remove the full path on disk, keep username and relative path to image.
            $pos = strpos($path, $GLOBALS["galleryDir"]);
            if ($pos !== false) {
                $cleanPath = substr_replace($path, "", $pos, strlen($GLOBALS["galleryDir"]));
            }

            //Check if the file is an image
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (in_array($ext, $GLOBALS["allowedExtensions"])) {
                $results[] = $cleanPath;
            }
        } else if ($value != "." && $value != ".." && $value != ".thumbnails") {
            //recursively scan directories
            getDirContents($path, $results);
        }
    }
    return $results;
}
$images = getDirContents($galleryDir);

$imageTemplate = '
<div class="card">
    <div class="card-image-div">
        <img src="%thumbnail" data-fullsrc="%path" alt="%name" class="card-image modal-target">
    </div>
    <div class="card-body">
        <p class="card-title">%realname</p>
        <p class="card-subtitle">%user</p>
    </div>
    <div class="card-footer">
        <p class="card-footer-item">%name</p>
        <p class="card-footer-item">%time</p>
    </div>
</div>
'


?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/gallery.css">
    <meta name="theme-color" content="#024" />
    <title>Fotoverkstedet</title>
</head>
<body>
    <nav id="navbar" class="">
        <?php echo navbar(1, 'galleri'); ?>
		<?php echo loginbar(null, $pdo); ?>
	</nav>
    <main class="gallery-container">
        <?php
        foreach ($images as $key => $value) {
            $modTime = date("d.m.Y H:i", filemtime($galleryDir . $value));
            $imguser = explode("/", $value)[1];
            $displaypath = implode("/", array_slice(explode("/", $value), 2));
            $realname = "Ukjent";
            foreach ($unamepairs as $unamepair) {
                $unamepair = explode(":", $unamepair);
                if ($unamepair[0] == $imguser) {
                    $realname = $unamepair[1];
                    break;
                }
            }

            $vars = [
                "%user"         =>  htmlspecialchars($imguser),
                "%time"         =>  $modTime,
                "%timestamp"    =>  filemtime($galleryDir . $value),
                "%name"         =>  htmlspecialchars($displaypath),
                "%path"         =>  $serverPath . $value,
		"%thumbnail"    =>  $serverPath . "/.thumbnails" . $value . ".png",
                "%realname"     =>  htmlspecialchars($realname)
            ];
            echo strtr($imageTemplate, $vars);
        }

        if (count($images) == 0) {
          echo "<h3 class='no-images'>Det er dessverre ingen bilder å vise.</h3>";
        }

        ?>
    </main>
    <div id="modal" class="modal">
        <span id="modal-close" class="modal-close">&#10006;</span>
        <img id="modal-content" class="modal-content">
        <div id="modal-caption" class="modal-caption"></div>
    </div>
    <script type="text/javascript" src="../js/galleri.js"></script>
</body>
</html>
