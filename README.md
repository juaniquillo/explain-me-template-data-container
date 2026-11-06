# explain-me-data-container

**Live demo:** https://explain-me-template-data-container.pages.dev/

Starter for the weekly explain-me tradition.

Each week: pick one piece of tech you worked on but don't fully understand → create `explain-me-<topic>` from this template → learn it via a tiny demo.

## Use this template

1. GitHub → `Use this template` → name it `explain-me-<topic>`
2. Fill `TOPIC.md` (short or long, as needed)
3. Fill tech-specific `AGENTS.md` under `## Per-topic overrides`
4. Paste `prompt.md` as your first prompt to the model
5. Build the `src/` demo (one concept, single run command, no deps)
6. Fill `README.md` explanation sections below
7. Copy `LOG-ENTRY.md` row into your central log

## Explanation format (fill per-topic)

### What

`DataContainer` (`src/DataContainer.php`) is a `final`, single-generic (`@template TValue`) wrapper around `array<array-key, TValue>`. The class itself is 29 lines — `use IsDataContainer` + `static::make()` — with all behavior in the `IsDataContainer` trait and the contract in `DataContainerInterface` (`IteratorAggregate + Countable + ArrayAccess`, `get/set/fill/merge/push/contains/missing/toArray/all`).

### Why

Bare PHP arrays allow any shape, so CRUD payloads passed between actions/inputs get no object syntax, no missing-key errors, and no-phpdoc element typing. `DataContainer` gives `$c->key` / `$c['key']` / `$c->get('key')`, throwing reads, `contains()/missing()` guards, `count()`/`foreach`/JSON dump, and `@var array<array-key, TValue>` for PHPStan/Psalm — while staying a plain in-memory array (no validation, no nesting, no immutability).

### How demo works

`src/index.html` is a non-interactive reference page for a competent engineer new to PHP: just enough language semantics (final/trait/interface, magic methods, `ArrayAccess`, `array_merge`, `isset` vs `array_key_exists`, `@template`) to read `DataContainer`, then the container's own rules (three access styles, `fill`/`merge`/`push`, null trap, count/iterate/dump). Code snippets are highlighted at build time; `src/demo.php` (stdlib-only replica of `IsDataContainer`, true source marked at top) is the CLI truth the page is checked against.

Run it (Vite; `dist/` is the servable build output):

```sh
npm install
npm run dev     # local dev server
npm run build   # emits dist/
npm run preview # serves dist/ locally
```

PHP truth stays runnable without composer:

```sh
php -l src/demo.php
php src/demo.php
```

Env: Node 26 + PHP >= 8.1 CLI (tested PHP `8.4.16`). Copy `.env.example` to `.env` for local builds (any `VITE_SITE_URL` works); hosting sets `VITE_SITE_URL=https://your-domain` at build time. After editing `src/index.html`, re-run `node tools/inject-source.mjs` then `npm run build`.

### Gotchas

- Split: `DataContainerInterface` = contract for type-hints; `IsDataContainer` = reusable implementation (other containers reuse it); `DataContainer` = the concrete `final` generic users instantiate. `static::make()` is late-static-binding, but the class is `final` so it equals `new self`.
- Read styles: `get()`, `[]`, `->prop` all return the same value and all throw `InvalidArgumentException` on missing keys (`src/demo.php` section 2). Writes differ: `set()` is chainable (`: static`), `__set`/`offsetSet` return `void`.
- Bulk ops: `fill($d)` **replaces** `$this->data`; `merge($d)` = `array_merge` (string keys overwritten, **int keys renumbered/appended, never overwritten by key**); `push($v)` = `$data[] = $v`. `offsetSet(null, $v)` (i.e. `$c[] = $v`) also appends.
- Null trap: `contains()/missing()/get()/__get/offsetGet` use `array_key_exists` → a `null`-valued key **exists**. `isset($c->k)`, `isset($c[k])` (`__isset`/`offsetExists` use `isset()`) → return **false** for `null`. Never use `isset` to test presence; use `contains()` or `missing()`.
- `@template TValue`: phpdoc-only. Runtime enforces only `array`, never the value type — `make(['s' => 'str', 'i' => 42])` runs fine. Element typing comes from PHPStan/Psalm, not PHP.
- Extras: `toArray()` and `all()` are identical; `__toString` is `json_encode($data) ?: '{}'`; `__unset`/`offsetUnset` both `unset()` silently even if missing.

### Sources

- `src/index.html` + `src/demo.php` (this repo — the things being explained)
- Lesson target: https://github.com/juaniquillo/crud-assistant/blob/main/src/DataContainer.php
- Logic: `src/Concerns/IsDataContainer.php`, contract: `src/Contracts/DataContainerInterface.php` (fetched via raw GitHub for this lesson)
- Runtime: Node 26 + PHP 8.4.16, `npx tsc --noEmit` + `npm run build` + `vite preview` + curl + `php src/demo.php` verification

### Template friction

- `tools/inject-source.mjs` assumes one full-file source viewer (`max-h-[480px]` pre) — fine here (`src/demo.php`), but a lesson with two equal sources would need a second viewer.
- One serving story per lesson holds: the site is the served demo, `src/demo.php` is its CLI truth/generator, not a second served thing.

## Files

- `prompt.md` — universal first prompt (does not change per-topic)
- `TOPIC.md` — variable part: what you worked on, what you think, what confuses you
- `AGENTS.md` — base instructions, plus tech-specific notes in each lesson
- `LOG-ENTRY.md` — table row snippet for central log
- `src/README.md` — demo rules

## Evolving this template

To make that easy:
- Keep this template minimal — don't add tech-specific stuff here
- When something feels missing in a lesson, note it in that lesson's README under `### Template friction`
- Every ~3 lessons, backport common fixes here
