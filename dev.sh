#!/bin/sh

which sqlite3 > /dev/null 2>&1 && test \! -e pvv.sqlite && sqlite3 pvv.sqlite < dist/pvv.sql
test \! -e sql_config.php && cp dist/sql_config_example.php sql_config.php

if test \! -d vendor; then
	composer install
	cp -v dist/authsources_example.php vendor/simplesamlphp/simplesamlphp/config/authsources.php
	cp -v dist/saml20-idp-remote.php vendor/simplesamlphp/simplesamlphp/metadata/saml20-idp-remote.php
	# cp -v vendor/simplesamlphp/simplesamlphp/config-templates/config.php vendor/simplesamlphp/simplesamlphp/config/config.php
	sed -e "s/'trusted.url.domains' => array()/'trusted.url.domains' => array('localhost:1080')/g" < vendor/simplesamlphp/simplesamlphp/config-templates/config.php > vendor/simplesamlphp/simplesamlphp/config/config.php
	ln -s ../vendor/simplesamlphp/simplesamlphp/www/ www/simplesaml
fi

php -S [::1]:1080 -t www/
