#!/usr/bin/env bash
# SessionStart(compact|resume): re-inject the open change artifact, changed files and governing rules.
cd "${CLAUDE_PROJECT_DIR:-$(pwd)}" || exit 0
art=$(ls -t .factory/changes/*.md 2>/dev/null | grep -v TEMPLATE | while read -r f; do grep -q '^Status: shipped' "$f" || { echo "$f"; break; }; done)
echo "## Factory context"
[ -n "$art" ] && echo "Open artifact: $art ($(wc -l < "$art") lines) — read it before continuing." || echo "No open change artifact."
base=$(git rev-parse --verify -q main >/dev/null && echo main || echo HEAD)
changed=$( { git diff --name-only "$base"...HEAD 2>/dev/null; git status --porcelain | cut -c4-; } | sort -u)
[ -n "$changed" ] && { echo "Changed files:"; echo "$changed" | sed 's/^/- /'; }
echo "Blueprint: blueprint.md (read only the section for the page in progress)."
for r in .claude/rules/*.md; do
  [ -f "$r" ] || continue
  globs=$(sed -n '/^paths:/,/^---/p' "$r" | grep -o '"[^"]*"' | tr -d '"')
  for g in $globs; do
    re="^$(echo "$g" | sed -e 's/\./\\./g' -e 's/\*\*/§/g' -e 's/\*/[^\/]*/g' -e 's/§/.*/g')$"
    echo "$changed" | grep -qE "$re" && { echo "Re-read rule: $r"; break; }
  done
done
exit 0
