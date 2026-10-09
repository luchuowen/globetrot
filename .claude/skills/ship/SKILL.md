---
name: ship
description: Learn, commit and push a verified change. Use for "/ship".
disable-model-invocation: true
---
1. Require a green `factory-check full` recorded in the artifact.
2. Write 0–3 bullets in the artifact's `## Learned`; append still-true, expensive-to-rediscover facts to .factory/DECISIONS.md (compact into .factory/history/ if over cap).
3. Set `Status: shipped`; `git add` the diff + artifact; one commit `<type>(<scope>): <summary>`; `git push -u origin HEAD`. Open a PR if on a branch. Never merge.
