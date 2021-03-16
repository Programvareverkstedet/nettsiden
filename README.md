# Programvareverkstedet nettside

A website created with the latest and greatest web technologies.
May contain blackjack and other things one tends to include in awesome projects.

## Installation

	git clone --recursive https://github.com/Programvareverkstedet/nettsiden.git

Put it in a folder your webserver can find.

## Development setup

Make sure you have sqlite3 and PHP installed, with pdo-sqlite module.
These can be obtained from your package manager.

	./dev.sh

On Windows, you have to perform a `composer install` manually beforehand. Make sure you have PHP and sqlite3 available in path:

	dev.bat

### Dependency management

`dev.sh` will ensure the git submodules have been pulled, then download the `composer` package manager to the php archive file `composer.phar` and run it.
Composer will check for the php extension `pdo_sqlite` which must be enabled on your system. This usually includes installing a php-sqlite3 package and enabling it in /etc/php/php.ini:

    [PHP]
    extension=pdo_sqlite
    extension=sqlite3
	extension=ext-curl

Composer is used as such:

    php composer.phar update
    php composer.phar install

## Hosting
