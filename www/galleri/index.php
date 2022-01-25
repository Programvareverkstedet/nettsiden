<?php
error_reporting(0);
require_once dirname(dirname(__DIR__)) . implode(DIRECTORY_SEPARATOR, ['', 'inc', 'include.php']);

$pdo = new \PDO($dbDsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

#$userManager = new \pvv\admin\UserManager($pdo);
#
#$as = new SimpleSAML_Auth_Simple('default-sp');
#$as->requireAuth();
#$attrs = $as->getAttributes();
#$loginname = $attrs['uid'][0];
#
#if(!$loginname) {
#	header('Content-Type: text/plain', true, 403);
#	echo "Du må være logget inn for å se bildegalleriet.\r\n";
#	exit();
#}
#
#
$unamefile = __DIR__ . '/usernames.txt';
$relativePath = "/bilder/pvv-photos/";
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];

$unamepairs = file($unamefile);
$fullPath = getcwd() . $relativePath;

function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);
    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            //Remove the full path on disk, keep username and relative path to image. ( $results[] = str_replace($GLOBALS["fullPath"], "", $path); is insecure.)
            $pos = strpos($path, $GLOBALS["fullPath"]);
            if ($pos !== false) {
                $cleanPath = substr_replace($path, "", $pos, strlen($GLOBALS["fullPath"]));
            }

            //Check if the file is an image
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if (in_array($ext, $GLOBALS["allowedExtensions"])) {
                $results[] = $cleanPath;
            }
        } else if ($value != "." && $value != "..") {
            //recursively scan directories
            getDirContents($path, $results);
        }
    }
    return $results;
}
$images = getDirContents($fullPath);

$imageTemplate = '
<div class="card">
    <div class="card-image-div">
        <img src="%path" alt="%name" class="card-image modal-target">
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
    <link rel="stylesheet" href="../css/bulma.min.css">
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
                "%user"         =>  htmlspecialchars($imguser),
                "%time"         =>  $modTime,
                "%timestamp"    =>  filemtime($fullPath . $value),
                "%name"         =>  htmlspecialchars($displaypath),
                "%path"         =>  "/galleri/" . $relativePath .$value,
                "%realname"     =>  htmlspecialchars($realname)
            ];
            echo strtr($imageTemplate, $vars);
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
