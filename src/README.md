# src demo rules

- One concept only. If you need two concepts, make two repos.
- One primary run command (e.g. `npm run dev`, `python -m http.server`, `cargo run`). Secondary commands (build/preview/typecheck) are fine but one must be primary and servable. One serving story per lesson, not two.
- Prefer small, dependency-free tech. If dependencies exist, list them with versions and why each is needed. Record the exact run command and any env requirements (runtime, `.env` location and required vars).
- Demo must directly illustrate the confusion in `TOPIC.md`.
- Interactive webpages must be well-styled: Tailwind (or equivalent), syntax highlighting for all code blocks, light/dark toggle defaulting to system. Styling serves the concept — keep the demo itself visually quiet.
- Generated artifacts must be reproducible: if the demo embeds generated output (e.g. highlighted code), the generating script is committed and documented, with the true source clearly marked.
- Verify by execution before calling it done: build, serve + curl, typecheck — on a clean checkout, not just the dev server.
- Document the run command in the per-lesson `README.md` under `How demo works`, and append a `## Run` section here with the exact commands + env setup.
- Credit the lineage: every lesson notes where it came from — the lesson repo and the template repo (`https://github.com/juaniquillo/explain-me-template`). A small footer works for webpages; a closing line in CLI output or a Sources link works for anything else. Quiet, same style as the output.

## Run

From repo root: `npm install`, then `npm run dev` (dev server), `npm run build` (emits `dist/`), `npm run preview` (serves `dist/`). Any static server works too, e.g. `npx serve dist`.

`src/demo.php` (stdlib-only replica of `IsDataContainer`, true source marked at top) is the CLI truth the page is checked against: `php -l src/demo.php`, `php src/demo.php` (PHP >= 8.1, tested 8.4.16).

`og:image` needs an absolute URL: copy `.env.example` to `.env` and set `VITE_SITE_URL` (any value works locally). Hosting sets `VITE_SITE_URL=https://your-domain` as a build environment variable instead — without it, the meta tags render a broken `%VITE_SITE_URL%` placeholder.

`tools/inject-source.mjs` Shiki-highlights the `<details>` source viewer and every walkthrough snippet (`<pre class="shiki">`, `php` by default, `data-lang` overrides) in `index.html`. `demo.php` and the hand-written snippets stay the sources of truth. After editing `index.html`, re-run `node tools/inject-source.mjs` then `npm run build`.
