# AGENTS.md

Base instructions for explain-me repos. See `README.md` and `src/README.md` for workflow.

Template itself has no run command. Each lesson must define one primary run command for its `src/` demo and document it in `README.md` under `How demo works` and in `src/README.md` under `## Run`.

Stay in build mode for the whole lesson; small decisions in conversation, no plan/build ping-pong.

Append `SESSION.md` per prompt/response round. Keep the one-row `LOG-ENTRY.md` summary separate — transcript and pointer stay separate.

Verify by execution before calling it done: build, serve + curl, typecheck — on a clean checkout, not just the dev server.

## Per-topic overrides

<!-- Fill per-lesson with stack-specific commands and explanation method. Example:
- Run: `npm run dev` (primary), `npm run build` + `npm run preview`, `npm run typecheck`
- Deps: `vite@7` (dev server + build), `tailwindcss@4` (demo styling) — why each is needed
- Env: `.env` location + required vars (e.g. `VITE_SITE_URL`)
- Method for this tech: overall / usage examples / code walkthrough / interactive + graphs / gotchas
- Gitignore: append the lines your stack needs (e.g. Node: `node_modules/ dist/` / Python: `__pycache__/ .venv/`)
-->
