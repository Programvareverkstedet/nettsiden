# Programvareverkstedets nettside

A website created with the latest and greatest web technologies.
May contain blackjack and other things one tends to include in awesome projects.

## Installation

	git clone --recursive https://github.com/Programvareverkstedet/nettsiden.git

Put it in a folder your webserver can find.

## Development setup

Make sure you have `sqlite3`, `php` and `pdo-sqlite` installed.
These can be obtained from your package manager.
Then make sure PHP has the `curl`, `pdo-sqlite` and `sqlite3` extensions enabled, see `/etc/php/php.ini`.

	./dev.sh

On Windows you can use chocolatey and git bash to run `./dev.sh`.
Install `php` and `sqlite`, then enable these extensions in `C:\tools\php80\php.ini`:
`mbstring`, `openssl`, `curl`, `pdo-sqlite` and `sqlite3`

Alternatively you may use `cmd` on Windows.
In this case you'll have to perform a `composer install` manually beforehand.
Good luck.

	dev.bat


### Dependency management

`dev.sh` will ensure the git submodules have been properly pulled, then download the `composer` package manager to a php archive file named `composer.phar`, then run it.
Composer will then check for the php extensions needed, such as `pdo_sqlite`, which must be enabled on your system.
This usually includes installing a php-sqlite3 package and enabling it in `/etc/php/php.ini`:

    [PHP]
    extension=pdo_sqlite
    extension=sqlite3
		extension=ext-curl

Composer is used as such:

    php composer.phar update
    php composer.phar install


### Docker

We provide a simple docker-compose setup for local development.
First ensure that docker is running:

	sudo systemctl start docker

then

	DOCKER_USER=$(id -u):$(id -g) docker-compose up


### Admin account

Login goes through `idp.pvv.ntnu.no` via SAML, so you have to use your PVV account.
(This only works if you use access the local development site via the the hostname `localhost`)
To make your account into an admin account, run:

    sqlite3 pvv.sqlite 'INSERT INTO users (uname, groups) VALUES ("YOUR_USERNAME", 1);'

If using docker, when already running:

    DOCKER_USER=$(id -u):$(id -g) docker-compose exec nettside sqlite3 pvv.sqlite 'INSERT INTO users (uname, groups) VALUES ("YOUR_USERNAME", 1);'

If not already running:

    DOCKER_USER=$(id -u):$(id -g) docker-compose run nettside sqlite3 pvv.sqlite 'INSERT INTO users (uname, groups) VALUES ("YOUR_USERNAME", 1);'


## Hosting
