---
name: factory
description: Factory status, migrate or init per docs/Software_Factory_Playbook.md. Use for "/factory status|migrate|init".
disable-model-invocation: true
---
- `status`: print manifest.playbook_version, applied_migrations, line counts of CLAUDE.md and .factory/DECISIONS.md vs caps, and `bash scripts/factory-check.sh gates`.
- `migrate`: read only the `## Migration from` entries newer than manifest.playbook_version in docs/Software_Factory_Playbook.md; replace factory-owned files, merge project-owned ones; record the version in applied_migrations; write a change artifact.
- `init`: playbook §7.
