---
name: verify
description: Prove a change is done. Use before claiming any change complete.
disable-model-invocation: true
---
1. `bash scripts/factory-check.sh full`; paste the tail into the artifact's Verification section.
2. For UI work: `npm run build && npm run preview`, screenshot the page at 390px and 1440px with Playwright, check the acceptance checks from Spec.
3. Run the `reviewer` agent against the artifact + diff; critical also `web-quality-review`. Fix every reported bug, record findings and fixes.
