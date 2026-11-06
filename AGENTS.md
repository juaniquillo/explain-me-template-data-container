# AGENTS.md

Base instructions for explain-me repos. See `README.md` and `src/README.md` for workflow.

Template itself has no run command. Each lesson must define one primary run command for its `src/` demo and document it in `README.md` under `How demo works` and in `src/README.md` under `## Run`.

Stay in build mode for the whole lesson; small decisions in conversation, no plan/build ping-pong.

Append `SESSION.md` per prompt/response round. Keep the one-row `LOG-ENTRY.md` summary separate — transcript and pointer stay separate.

Verify by execution before calling it done: build, serve + curl, typecheck — on a clean checkout, not just the dev server.

## Per-topic overrides

- Run: `npm run dev` (primary, serves `src/`), `npm run build` (emits `dist/`), `npm run preview` (serves `dist/`). Secondary: `php src/demo.php` (CLI truth), `node tools/inject-source.mjs` (re-highlight after editing `index.html`). Verify: `npx tsc --noEmit` + `npm run build` + `vite preview` + curl + `php -l src/demo.php`.
- Deps: `vite@8` (dev server + build), `tailwindcss@4` + `@tailwindcss/vite@4` (demo styling), `shiki@4` (highlight `php` snippets + source viewer at build time), `typescript@5` + `@types/node` (typecheck `main.ts`/`vite.config.ts`). PHP side: none (stdlib only — `IteratorAggregate, Countable, ArrayAccess`). `src/demo.php` inlines a faithful replica of `IsDataContainer`; no composer package needed.
- Env: Node 26 + PHP >= 8.1 CLI (tested PHP 8.4.16). `.env` at repo root (copy `.env.example`, any `VITE_SITE_URL` works locally); hosting sets `VITE_SITE_URL=https://your-domain` at build time for og:image.
- Method for this tech: reference (non-interactive) for a competent engineer new to PHP — overall + PHP-primer table (final/trait/interface, magic methods, `ArrayAccess`, `array_merge`, `isset` vs `array_key_exists`, `@template`) + code walkthrough + CLI-checked outputs + gotchas.
- Gitignore: `node_modules/ dist/ .env .env.local` (+ base OS/editor lines).
