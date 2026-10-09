#!/usr/bin/env bash
# PreToolUse (Edit|Write): protected paths, append-only dirs, wasteful whole-file Writes. Exit 2 = block.
cd "${CLAUDE_PROJECT_DIR:-$(pwd)}" || exit 0
exec node --input-type=module -e '
import { readFileSync, existsSync } from "node:fs";
import { relative, isAbsolute } from "node:path";
import { execSync } from "node:child_process";
import { root, manifest, matchAny } from "./scripts/factory-lib.mjs";
const ev = JSON.parse(readFileSync(0, "utf8") || "{}");
const ti = ev.tool_input || {};
const fp = ti.file_path || ti.path || "";
if (!fp) process.exit(0);
const rel = isAbsolute(fp) ? relative(root, fp) : fp;
const block = (m) => { process.stderr.write("guard: " + m + "\n"); process.exit(2); };
if (matchAny(rel, manifest.protected)) block(rel + " is protected; owner must name this exact file to unlock it (edit .factory/manifest.json).");
for (const d of manifest.append_only_dirs || []) {
  if (rel.startsWith(d.replace(/\/$/, "") + "/")) {
    try { execSync("git cat-file -e HEAD:" + JSON.stringify(rel).slice(1, -1), { stdio: "ignore" }); block(rel + " is committed in an append-only dir; add a new file instead."); } catch {}
  }
}
if (ev.tool_name === "Write" && existsSync(fp) && typeof ti.content === "string") {
  const old = readFileSync(fp, "utf8").split("\n");
  if (old.length >= 150) {
    const pool = new Map(); for (const l of ti.content.split("\n")) pool.set(l, (pool.get(l) || 0) + 1);
    let changed = 0; for (const l of old) { const c = pool.get(l) || 0; if (c) pool.set(l, c - 1); else changed++; }
    if (changed / old.length < 0.25) block("Write re-emits " + old.length + " lines to change " + changed + "; use Edit.");
  }
}
'
