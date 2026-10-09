// Shared helpers for factory scripts and hooks. No dependencies.
import { readFileSync, readdirSync, statSync, existsSync } from 'node:fs';
import { join, relative } from 'node:path';

export const root = process.env.CLAUDE_PROJECT_DIR || process.cwd();
export const manifest = JSON.parse(readFileSync(join(root, '.factory/manifest.json'), 'utf8'));

export function globToRe(g) {
  const s = g.replace(/[.+^${}()|[\]\\]/g, '\\$&')
    .replace(/\*\*\/?/g, '\u0000').replace(/\*/g, '[^/]*').replace(/\?/g, '[^/]')
    .replace(/\u0000/g, '.*');
  return new RegExp('^' + s + '$');
}
export const matchAny = (rel, globs = []) => globs.some((g) => globToRe(g).test(rel));

const SKIP = new Set(['node_modules', '.git', 'dist', '.astro', '.vercel', '.netlify']);
export function walk(dir = root, out = []) {
  if (!existsSync(dir)) return out;
  for (const n of readdirSync(dir)) {
    if (SKIP.has(n)) continue;
    const p = join(dir, n);
    const st = statSync(p);
    if (st.isDirectory()) walk(p, out); else out.push(relative(root, p));
  }
  return out;
}

export function runGates() {
  const fails = [];
  const files = walk();
  for (const g of manifest.gates || []) {
    const re = new RegExp(g.pattern);
    for (const f of files) {
      if (!matchAny(f, g.paths) || matchAny(f, g.exclude)) continue;
      if (/\.(png|jpe?g|webp|avif|gif|ico|woff2?|mp4|pdf)$/i.test(f)) continue;
      readFileSync(join(root, f), 'utf8').split('\n').forEach((line, i) => {
        if (re.test(line)) fails.push(`gate ${g.name}: ${f}:${i + 1}: ${line.trim().slice(0, 120)}`);
      });
    }
  }
  for (const [f, cap] of Object.entries(manifest.caps || {})) {
    const p = join(root, f);
    if (!existsSync(p)) continue;
    const n = readFileSync(p, 'utf8').split('\n').length;
    if (n > cap) fails.push(`cap: ${f} has ${n} lines > ${cap} — compact into .factory/history/`);
  }
  return fails;
}

if (process.argv[2] === 'gates') {
  const f = runGates();
  if (f.length) { console.error(f.join('\n')); process.exit(1); }
  console.log('gates: green');
}
if (process.argv[2] === 'check') {
  const c = (manifest.checks || {})[process.argv[3]] || '';
  process.stdout.write(c);
}
