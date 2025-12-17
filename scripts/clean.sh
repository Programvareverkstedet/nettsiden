#!/usr/bin/env bash

set -euo pipefail

REQUIRED_COMMANDS=(git grep)
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

declare -r GIT_TREE_IS_DIRTY="$(
  if ! git diff --quiet --ignore-submodules \
     || git ls-files --others --exclude-standard | grep -q .; then
    echo 1
  else
    echo 0
  fi
)"

if [ "$GIT_TREE_IS_DIRTY" == "1" ]; then
  echo "Git working tree is dirty, refusing to reset" >&2
  exit 1
fi

declare -r PROJECT_ROOT="$(git rev-parse --show-toplevel)"

(
  cd "$PROJECT_ROOT"
  git clean -fdx
)
