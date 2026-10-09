---
name: change
description: Open a change artifact and size the work. Use for "/change <slug>" or before any non-trivial edit.
disable-model-invocation: true
---
1. Size from the paths the intent touches (manifest.critical_paths → critical; one-sentence diff, no new dep → trivial; else standard). Trivial: no artifact, stop here.
2. Copy .factory/changes/TEMPLATE.md to .factory/changes/<YYYY-MM-DD>-<slug>.md.
3. Fill Intent with the ask, user-visible outcome, out of scope and EVERY known constraint (from blueprint.md section for that page + DECISIONS.md). Ask the owner once only at a genuine fork.
4. Critical: enter plan mode and tell the owner to run `/effort high`; domain reviewer `web-quality-review` is mandatory.
5. Fill Spec (behaviour, files, edge cases, acceptance checks) and Plan (ordered steps + verification each), then build.
