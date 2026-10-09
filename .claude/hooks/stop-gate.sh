#!/usr/bin/env bash
# Stop: run the quick gate when tracked source changed since the last green run. Exit 2 = keep working.
cd "${CLAUDE_PROJECT_DIR:-$(pwd)}" || exit 0
input=$(cat)
echo "$input" | grep -q '"stop_hook_active": *true' && exit 0
stamp=.factory/.last-green
hash=$( { git status --porcelain; git diff; } 2>/dev/null | shasum | cut -c1-40)
[ -f "$stamp" ] && [ "$(cat "$stamp")" = "$hash" ] && exit 0
if out=$(bash scripts/factory-check.sh quick 2>&1); then
  echo "$hash" > "$stamp"; exit 0
fi
echo "factory-check quick is red — fix before ending the turn:" >&2
echo "$out" | tail -40 >&2
exit 2
