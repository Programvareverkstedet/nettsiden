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

# Loop over the last 4 days' unix timestamps in 5-minute intervals and insert test data
END_TIME=$(date +%s)
START_TIME=$((END_TIME - 4 * 24 * 60 * 60))
for ((timestamp=START_TIME; timestamp<=END_TIME; timestamp+=60 * 5 * 10)); do
  RANDOM_YES_NO=$((RANDOM % 2))
  sqlite3 "$PROJECT_ROOT/pvv.sqlite" <<EOF
INSERT INTO
  door(time, open)
VALUES
  ($timestamp + 60 * 5 * 0, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 1, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 2, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 3, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 4, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 5, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 6, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 7, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 8, $RANDOM_YES_NO),
  ($timestamp + 60 * 5 * 9, $RANDOM_YES_NO);
EOF
done
