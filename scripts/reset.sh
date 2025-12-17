#!/usr/bin/env bash

set -euo pipefail

REQUIRED_COMMANDS=(git)
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

"$PROJECT_ROOT/scripts/clean.sh"
"$PROJECT_ROOT/scripts/setup.sh"
