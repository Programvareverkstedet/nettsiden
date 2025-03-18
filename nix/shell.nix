{ pkgs, lib }:
let
  phpEnv = pkgs.php84.buildEnv {
    extensions = { enabled, all }: enabled ++ (with all; [ iconv mbstring pdo_mysql pdo_sqlite ]);
  };
in
pkgs.mkShellNoCC {
  buildInputs = with pkgs; [
    phpEnv
    php84Packages.composer
    php84Packages.php-parallel-lint
    php84Packages.php-cs-fixer
    sqlite-interactive
    sql-formatter
  ];

  # Prepare dev environment with sqlite and config files
  shellHook = ''
    alias runDev='php -S localhost:1080 -d error_reporting=E_ALL -d display_errors=1 -t www/'

    declare -a PROJECT_ROOT="$("${lib.getExe pkgs.git}" rev-parse --show-toplevel)"

    mkdir -p "$PROJECT_ROOT/www/galleri/bilder/slideshow"
    test -e "$PROJECT_ROOT/pvv.sqlite" || sqlite3 "$PROJECT_ROOT/pvv.sqlite" < "$PROJECT_ROOT/dist/pvv_sqlite.sql"
    test -e "$PROJECT_ROOT/config.php" || cp -v "$PROJECT_ROOT/dist/config.local.php" "$PROJECT_ROOT/config.php"

    if [ ! -d "$PROJECT_ROOT/vendor" ] ; then
      pushd "$PROJECT_ROOT"
      composer install || exit $?

      cp dist/simplesamlphp-authsources.php vendor/simplesamlphp/simplesamlphp/config/authsources.php
      cp dist/simplesamlphp-idp.php vendor/simplesamlphp/simplesamlphp/metadata/saml20-idp-remote.php
      cp dist/simplesamlphp-config.php vendor/simplesamlphp/simplesamlphp/config/config.php

      cp dist/config.local.php config.php

      ln -s ../vendor/simplesamlphp/simplesamlphp/public/ www/simplesaml
      popd "$PROJECT_ROOT"
    fi
  '';
}
