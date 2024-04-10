<?php

$DB_DSN = 'sqlite:'.__DIR__.DIRECTORY_SEPARATOR.'pvv.sqlite';
$DB_USER = null;
$DB_PASS = null;

$DOOR_SECRET = "changeme";

$GALLERY_DIR = __DIR__.DIRECTORY_SEPARATOR.'www'.DIRECTORY_SEPARATOR.'galleri'.DIRECTORY_SEPARATOR.'bilder'.DIRECTORY_SEPARATOR.'gallery';
$GALLERY_SERVER_PATH = '/images/gallery/';

$SLIDESHOW_DIR = __DIR__.DIRECTORY_SEPARATOR.'www'.DIRECTORY_SEPARATOR.'galleri'.DIRECTORY_SEPARATOR.'bilder'.DIRECTORY_SEPARATOR.'slideshow';
$SLIDESHOW_SERVER_PATH = '/images/slideshow/';

$SAML_COOKIE_SALT = 'changeme';
$SAML_COOKIE_SECURE = false;
$SAML_TRUSTED_DOMAINS = array("localhost:1080");
$SAML_ADMIN_PASSWORD = "changeme";
$SAML_ADMIN_NAME = 'PVV Drift';
$SAML_ADMIN_EMAIL = 'drift@pvv.ntnu.no';

$CACHE_DIRECTORY = __DIR__.DIRECTORY_SEPARATOR.'cache';

?>
