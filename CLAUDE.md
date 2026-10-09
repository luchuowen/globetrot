# Globetrot Cargolink International — agent rules (factory v2.1)

Premium marketing website for a Nairobi freight-forwarding & logistics company. Source of truth for
pages, copy, images and build order: `blueprint.md` (read only the section you are building).

## Commands
- verify quick: `bash scripts/factory-check.sh quick` · full: `bash scripts/factory-check.sh full`
- dev: `npm run dev` · build: `npm run build` · preview: `npm run preview` (set by the walking skeleton)

## Loop
1. `/change <slug>` sizes the work and opens `.factory/changes/…` (trivial = no artifact). One page = one change.
2. Critical paths (`.factory/manifest.json`: forms/API, deploy, config) → plan mode, `/effort high`, `web-quality-review`.
3. Build. The Stop hook runs the quick gate; a red gate is a blocker, not a note.
4. `/verify` before claiming done; `/ship` to learn, commit, push. Agents never merge.

## Working style
- Scope = the ask: pre-existing bugs and nearby cleanups go in the summary as follow-ups, not the diff.
- Tests sized like their neighbours; scratch checks are not new test files.
- Batch every read/search/command that does not depend on another's result into one response.
- Own the whole mission: the owner is usually not watching; never ask permission for work already
  requested; end the turn only when done or blocked on input only the owner has.
- Owner (Owen) wants terse reports, one step at a time when he must act, and finished pages over many half-built ones.

## Invariants without a mechanical check
- Never invent business facts (years, fleet size, clients, licences, stats). Use `{{OWNER: …}}` tokens.
- Design tokens only (colours, type, spacing live in one tokens file); components never hard-code them.
- Images: generated/licensed only, stored in `src/assets/img/`, slot IDs match blueprint §Image slots.
- Mobile-first; every page checked at 390 / 768 / 1440 px; WCAG 2.2 AA; LCP image preloaded.
- No feature or page outside blueprint.md without the owner's sign-off.

## Memory
- `.factory/DECISIONS.md` is current truth; read it before assuming something is unbuilt.
- `/ship` appends what was learned; `factory-check` fails when it exceeds its cap → compact.
- After `/compact`/resume the SessionStart hook names the rule files to re-read; skills re-load by name.
