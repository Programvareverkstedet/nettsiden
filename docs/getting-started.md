# Getting started

Let's get you up and running.

## List of dependencies

You will need to install the following pieces of software:

- Git
- SQLite3
- PHP
- Composer
- OpenSSL

If you are running Ubuntu or Debian, you can install these dependencies with:

```bash
sudo apt update
sudo apt install git sqlite3 php composer openssl
```

## Automatic setup

You can use the scripts in the `scripts/` directory to quickly set up a development environment.

By running the `./scripts/setup.sh`, all dependencies will be installed, in addition to other miscellaneous setup tasks. You can then run `./scripts/run.sh` to start the webserver.

You should now be able to access the site at [http://localhost:1080](http://localhost:1080).

Sometimes it is useful to completely reset the state of the project, deleting the data, redownloading dependencies, etc. You can do this by running `./scripts/reset.sh`. Be careful, as this will delete all data in the database!

> [!WARNING]
> Even when resetting the project with the reset script, there are some situation where you need to clear your cookies or your browser cache to get a clean state.
> How to do this varies between browsers, so please refer to your browser's documentation for instructions.

## Setup with nix

We provide a devshell with all dependencies included. We do recommend still using the scripts for setup tasks.

```bash
nix develop
./scripts/setup.sh
./scripts/run.sh
```

## Logging in

We have a development configuration for SimpleSAMLphp (which we use as our authentication system), that lets you log in with dummy users while developing.

The available users are:

- `admin` (password: `admin`) - An admin user
- `user` (password: `user`) - A normal user

In addition, if you need to look into the SAML setup, you can log into the SimpleSAMLphp admin interface at [http://localhost:1080/simplesaml/admin](http://localhost:1080/simplesaml/admin) with username `admin` and password `123`.

## The codebase

In the codebase, you will find the following directories:

- `dist`: Contains files related to deployment, hosting and packaging.
- `docs`: Documentation for the project.
- `inc`: PHP include files, containing a base set of useful classes, functions and constants.
- `nix`: Nix config for packaging, devshells, NixOS modules, etc.
- `scripts`: Helper scripts for setting up development environments, running the server, etc.
- `src`: The main library code for the project. This contains raw PHP code with business logic and database access.
- `vendor`: Third-party dependencies installed with composer.
- `www`: The webroot for the project. This contains public assets, styling, javascript and PHP code concerned with routing and rendering webpages.

## How SimpleSAMLphp is set up in the development environment

It used to be the case that we would connect to our production instance of SimpleSAMLphp for authentication even in development environments. This is no longer the case, as we now use our local SimpleSAMLphp instance both as a service provider and as an identity provider in development. The `config.php` and `authsources.php` files are written in a way where one single instance of SimpleSAMLphp acts as both parts. It will send authentication requests to itself. See `dist/simplesaml-dev` for implementation details.
