#!/usr/bin/env bash

set -euo pipefail

REQUIRED_COMMANDS=(
  php
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

# Check for hints that our project might not be correctly set up
if [ ! -d "$PROJECT_ROOT/vendor" ] \
|| [ ! -f "$PROJECT_ROOT/config.php" ] \
|| [ ! -d "$PROJECT_ROOT/www/simplesaml" ] \
|| [ ! -d "$PROJECT_ROOT/www/galleri/bilder" ]; then
  echo "It looks like the project is not correctly set up." >&2
  exit 1
fi

declare -a PHP_ARGS=(
  -S localhost:1080
  -d error_reporting=E_ALL
  -d display_errors=1
  -t www/
)

(cd "$PROJECT_ROOT" && php "${PHP_ARGS[@]}")
