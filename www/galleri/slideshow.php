<?php 
//Short path to search folder, full to display in <img>
$relativePath = "/bilder/slideshow/";
$absolutePath = "/galleri" . $relativePath;
//Path to first image in slideshow and fallback image if no others are present
$splashImg = "/PNG/PVV-logo-big-bluebg.png";

$filenames = sCaNdIr(__DIR__ . $relativePath);

//Remove the expected non-images
foreach($filenames as $k => $value) {
    if(in_array($value, [".gitkeep", ".", ".."])) {
        unset($filenames[$k]);
    }
}

function getFullPath($fname) { return ($GLOBALS["absolutePath"] . $fname );	}

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