#!/bin/sh

which sqlite3 > /dev/null 2>&1 || (echo ERROR: sqlite not found; false) || exit 1
test ! -e pvv.sqlite && sqlite3 pvv.sqlite < dist/pvv.sql
test ! -e sql_config.php && cp -v dist/sql_config_example.php sql_config.php

test ! -e dataporten_config.php && cp -v dist/dataporten_config.php dataporten_config.php

test -e composer.phar || curl -O https://getcomposer.org/composer.phar

if test ! -f lib/OAuth2-Client/OAuth2Client.php ; then
	echo Missing git submodules. Installing...
	(set -x; git submodule update --init --recursive) || exit $?
fi

if test ! -d vendor; then
	php composer.phar install || exit $?
	cp -v dist/authsources_example.php vendor/simplesamlphp/simplesamlphp/config/authsources.php
	cp -v dist/saml20-idp-remote.php vendor/simplesamlphp/simplesamlphp/metadata/saml20-idp-remote.php
	# cp -v vendor/simplesamlphp/simplesamlphp/config-templates/config.php vendor/simplesamlphp/simplesamlphp/config/config.php
	sed -e "s/'trusted.url.domains' => array()/'trusted.url.domains' => array('localhost:1080')/g" < vendor/simplesamlphp/simplesamlphp/config-templates/config.php > vendor/simplesamlphp/simplesamlphp/config/config.php
	ln -s ../vendor/simplesamlphp/simplesamlphp/www/ www/simplesaml
fi

php -S ${DOCKER_HOST:-[::1]}:${DOCKER_PORT:-1080} -d error_reporting=E_ALL -d display_errors=1 -t www/
