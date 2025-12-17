#!/usr/bin/env bash

set -euo pipefail

REQUIRED_COMMANDS=(
  sqlite3
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

if [ ! -f "$PROJECT_ROOT/pvv.sqlite" ] ; then
  echo "Database file $PROJECT_ROOT/pvv.sqlite does not exist. Please run setup.sh first." >&2
  exit 1
fi

sqlite3 "$PROJECT_ROOT/pvv.sqlite" < "$PROJECT_ROOT/dist/sql/test_data_sqlite.sql"
