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
    openssl
  ];

  # Prepare dev environment with sqlite and config files
  shellHook = ''
    alias runDev='php -S localhost:1080 -d error_reporting=E_ALL -d display_errors=1 -t www/'

    declare -a PROJECT_ROOT="$("${lib.getExe pkgs.git}" rev-parse --show-toplevel)"

    mkdir -p "$PROJECT_ROOT/www/galleri/bilder/slideshow"
    test -e "$PROJECT_ROOT/pvv.sqlite" || sqlite3 "$PROJECT_ROOT/pvv.sqlite" < "$PROJECT_ROOT/dist/sql/pvv_sqlite.sql"
    test -e "$PROJECT_ROOT/config.php" || cp -v "$PROJECT_ROOT/dist/config.local.php" "$PROJECT_ROOT/config.php"

    if [ ! -d "$PROJECT_ROOT/vendor" ] ; then
      pushd "$PROJECT_ROOT"
      composer install || exit $?

      # Set up SimpleSAMLphp identity provider (for local testing)
      install -m644 dist/simplesaml-dev/authsources.php -t vendor/simplesamlphp/simplesamlphp/config/
      install -m644 dist/simplesaml-dev/config.php -t vendor/simplesamlphp/simplesamlphp/config/
      install -m644 dist/simplesaml-dev/saml20-idp-remote.php -t vendor/simplesamlphp/simplesamlphp/metadata/
      install -m644 dist/simplesaml-dev/saml20-idp-hosted.php -t vendor/simplesamlphp/simplesamlphp/metadata/
      install -m644 dist/simplesaml-dev/saml20-sp-remote.php -t vendor/simplesamlphp/simplesamlphp/metadata/

      # See session.phpsession.savepath in config.php
      mkdir -p vendor/simplesamlphp/simplesamlphp/sessions/

      openssl req \
        -newkey rsa:4096 \
        -new \
        -x509 \
        -days 3652 \
        -nodes \
        -out vendor/simplesamlphp/simplesamlphp/cert/localhost.crt \
        -keyout vendor/simplesamlphp/simplesamlphp/cert/localhost.pem \
        -subj "/C=NO/ST=Trondheim/L=Trondheim/O=Programvareverkstedet/CN=localhost"

      cp dist/config.local.php config.php

      ln -s ../vendor/simplesamlphp/simplesamlphp/public/ www/simplesaml
      popd
    fi
  '';
}
