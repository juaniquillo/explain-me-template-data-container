# explain-me-template

Starter for the weekly explain-me tradition.

Each week: pick one piece of tech you worked on but don't fully understand → create `explain-me-<topic>` from this template → learn it via a tiny demo.

## Use this template

1. GitHub → `Use this template` → name it `explain-me-<topic>`
2. Fill `TOPIC.md` fully — short or long as needed, no `<!-- ... -->` left. Include the origin link.
3. Fill tech-specific `AGENTS.md` under `## Per-topic overrides`
4. Paste `prompt.md` as your first prompt to the model (stay in build mode for the lesson)
5. Build the `src/` demo (one concept, one primary run command, deps with versions + why)
6. Fill `README.md` explanation sections below
7. Append `SESSION.md` per round, copy `LOG-ENTRY.md` row into your central log

Note: repo rulesets don't copy via `Use this template` — re-import the ruleset JSON in each lesson or use an org-level ruleset for `explain-me-*`.

## Explanation format (fill per-topic)

Pick the elaboration formats that fit (don't force all): overall explanation, usage examples, code walkthrough, interactive examples and graphs.

### What
One paragraph: what is this tech?

### Why
Why does it exist / what problem does it solve?

### How demo works
What the `src/` demo shows, exact run command + env setup.

### Gotchas
Answer the confusions in `TOPIC.md` explicitly. Edge cases, common mistakes.

### Sources
Link where the tech was originally used (repo, PR, or file) plus docs actually consulted.

### Template friction
What felt missing or awkward in this template while doing this lesson?

## Files

- `prompt.md` — universal first prompt (does not change per-topic)
- `TOPIC.md` — variable part: what you worked on, origin link, what you think, what confuses you
- `AGENTS.md` — base instructions, plus tech-specific notes in each lesson
- `SESSION.md` — running session log, appended per round
- `LOG-ENTRY.md` — table row snippet for central log (the pointer; transcript stays in `SESSION.md`)
- `src/README.md` — demo rules

## Evolving this template

To make that easy:
- Keep this template minimal — don't add tech-specific stuff here
- When something feels missing in a lesson, note it in that lesson's README under `### Template friction`
- Every ~3 lessons, backport common fixes here
