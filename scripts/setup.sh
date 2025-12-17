#!/usr/bin/env bash

set -euo pipefail

REQUIRED_COMMANDS=(
  git
  composer
  sqlite3
  openssl
  install
)
MISSING_COMMANDS=false
for cmd in "${REQUIRED_COMMANDS[@]}"; do
  if ! command -v "$cmd" &> /dev/null; then
    echo "$cmd could not be found" >&2
    MISSING_COMMANDS=true
  fi
done
if [ "$MISSING_COMMANDS" = true ]; then
  exit 1
fi

declare -r PROJECT_ROOT="$(git rev-parse --show-toplevel)"

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
