{
  description = "Programvareverkstedet/nettsiden PHP environment";

  inputs = {
    nixpkgs.url = "github:NixOS/nixpkgs/nixpkgs-unstable";
  };

  outputs = { self, nixpkgs }:
  let
    systems = [
      "x86_64-linux"
      "aarch64-linux"
      "aarch64-darwin"
    ];
    forAllSystems = f: nixpkgs.lib.genAttrs systems (system: f system);
  in {
    packages = forAllSystems (system: let
      pkgs = nixpkgs.legacyPackages.${system};
      php = pkgs.php83;
    in {
      default = self.packages.${system}.pvv-nettsiden;
      pvv-nettsiden = php.buildComposerProject (finalAttrs: {
        src = ./.;
        pname = "pvv-nettsiden";
        version = "0.0.1";
        vendorHash = "sha256-DSn0ifj7Hjjia1SF/1wfziD/IdsiOES8XNDVz3F/cTI=";
      });
    });
    devShells = forAllSystems (system: rec {
      pkgs = import nixpkgs { inherit system; };
      default = pkgs.mkShellNoCC {
        buildInputs = with pkgs; [
          php82
          (with php82Extensions; [
            iconv
            mbstring
            pdo_mysql
            pdo_sqlite
          ])
          sqlite
          git
        ];
        shellHook = ''
          export PHPHOST=localhost
          export PHPPORT=1080
          alias runDev='php -S $PHPHOST:$PHPPORT -d error_reporting=E_ALL -d display_errors=1 -t www/'

          # Prepare dev environment with sqlite and config files
          test -e pvv.sqlite || sqlite3 pvv.sqlite < dist/pvv.sql
          test -e sql_config.php || cp -v dist/sql_config_example.php sql_config.php

          test -e composer.phar || curl -O https://getcomposer.org/composer.phar

          if [ ! -d vendor ] ; then
            php composer.phar install || exit $?
            cp -v dist/authsources_example.php vendor/simplesamlphp/simplesamlphp/config/authsources.php
            cp -v dist/saml20-idp-remote.php vendor/simplesamlphp/simplesamlphp/metadata/saml20-idp-remote.php
            cp -v vendor/simplesamlphp/simplesamlphp/config-templates/config.php vendor/simplesamlphp/simplesamlphp/config/config.php
            sed -e "s/'trusted.url.domains' => array()/'trusted.url.domains' => array(\"$PHPHOST:$PHPPORT\")/g" < vendor/simplesamlphp/simplesamlphp/config-templates/config.php > vendor/simplesamlphp/simplesamlphp/config/config.php
            ln -s ../vendor/simplesamlphp/simplesamlphp/www/ www/simplesaml
          fi
        '';

        # TODO:
        # - Make "trusted.url.domains" dynamic based on the current host:port
        # - Do not download composer.phar with curl(!)
        # - Relicense the project to GPL or something
        # - Write a module for the project

      };
    });
  };
}
