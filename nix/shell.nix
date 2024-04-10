{ pkgs }:
let
  phpEnv = pkgs.php82.buildEnv {
    extensions = { enabled, all }: enabled ++ (with all; [ iconv mbstring pdo_mysql pdo_sqlite ]);
  };
in
pkgs.mkShellNoCC {
  buildInputs = with pkgs; [
    phpEnv
    php82Packages.composer

    sqlite
    git
  ];
  shellHook = ''
    alias runDev='php -S localhost:1080 -d error_reporting=E_ALL -d display_errors=1 -t www/'

    # Prepare dev environment with sqlite and config files
    test -e pvv.sqlite || sqlite3 pvv.sqlite < dist/pvv.sql
    test -e config.php || cp -v dist/config.local.php config.php


    if [ ! -d vendor ] ; then
      composer install || exit $?

      cp dist/simplesamlphp-authsources.php vendor/simplesamlphp/simplesamlphp/config/authsources.php
      cp dist/simplesamlphp-idp.php vendor/simplesamlphp/simplesamlphp/metadata/saml20-idp-remote.php
      cp dist/simplesamlphp-config.php vendor/simplesamlphp/simplesamlphp/config/config.php

      cp dist/config.local.php config.php

      ln -s ../vendor/simplesamlphp/simplesamlphp/www/ www/simplesaml
    fi
  '';
}
