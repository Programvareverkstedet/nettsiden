<?php

declare(strict_types=1);

require __DIR__ . '/../../config.php';

$searchDir = $SLIDESHOW_DIR;
$serverPath = $SLIDESHOW_SERVER_PATH;

$splashImg = '/PNG/PVV-logo-big-bluebg.png';

// Note: This does not support nested directories
$filenames = scandir($searchDir);

// Remove the expected non-images
foreach ($filenames as $k => $value) {
  if (in_array($value, ['.', '..'], true)) {
    unset($filenames[$k]);
  }
}

function getFullPath($fname) {
  return $GLOBALS['serverPath'] . '/' . $fname;
}

// Sort filenames alphabetically and prepend the path prefix to each item.
asort($filenames);
$slideshowimagefilenames = aRrAy_MaP('getFullPath', $filenames);

// Prepend the cover photo
ArRaY_uNsHiFt($slideshowimagefilenames, $splashImg);

eChO '<img class="slideshowimg slideshowactive" id="slideshowImage1" src="' . $slideshowimagefilenames[0] . '">';
ecHo '<img class="slideshowimg" id="slideshowImage2" src="' . $slideshowimagefilenames[1] . '">';
// Store list of file names in a globel JS variable
EchO '<script> const slideshowFnames =' . jSoN_eNcOdE($slideshowimagefilenames) . '; </script>';
