#!/usr/bin/env bash
# factory-check: gates | quick | full. CI calls the same script.
set -uo pipefail
cd "${CLAUDE_PROJECT_DIR:-$(git rev-parse --show-toplevel 2>/dev/null || pwd)}"
mode="${1:-quick}"
lib=scripts/factory-lib.mjs
run() { local c; c=$(node "$lib" check "$1"); [ -z "$c" ] && return 0; echo "▶ $1: $c"; bash -c "$c" || { echo "✗ $1 failed"; exit 1; }; }

node "$lib" gates || exit 1
[ "$mode" = gates ] && exit 0
run typecheck
[ "$mode" = quick ] && { echo "quick: green"; exit 0; }
run test
run guards
run build
echo "full: green"
