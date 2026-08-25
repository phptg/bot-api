---
name: bot-api-update
description: Implement support for a new Telegram Bot API version in this package. Use when asked to update the library to a new Bot API version.
---

# Telegram Bot API version update

Port a new Telegram Bot API release into this package, end to end.

Read `AGENTS.md` before writing any code — it holds the layout, class shapes, test patterns and
changelog rules the resulting diff is judged by. When in doubt, open a class added by the previous
Bot API commit (`git log --oneline --grep='Telegram Bot API'`) and copy its shape.

Copy the *shape* only, never the location: older commits still put new classes into the legacy
subdirectories (`src/Method/UpdatingMessage/DeleteEphemeralMessage.php`,
`src/Type/Payment/BotSubscriptionUpdated.php`). Where a file goes is decided by `AGENTS.md` alone —
every new type lands in `src/Type`, every new method in `src/Method`.

## 1. Repository state

```bash
git status --porcelain          # must be empty
git branch --show-current
git fetch origin
```

A dirty working tree stops the skill: report it and ask the user what to do.

If the current branch is already a Bot API branch (`apiXY`) started from the current
`origin/master` tip, stay on it and continue from wherever it left off — do not switch, do not
create a new branch, and skip to the first unfinished item of `runtime/bot-api-update/plan.md`.

Otherwise take the fresh `master` tip; the branch itself is created in step 3, once the target
version is known:

```bash
git switch master
git pull --ff-only origin master
```

## 2. Download the official pages

Everything this skill downloads or generates lives in `runtime/bot-api-update/` — `runtime/` is
fully gitignored, and the own subdirectory keeps these files apart from the other tools' output.

```bash
mkdir -p runtime/bot-api-update
curl -fsS -o runtime/bot-api-update/api-changelog.html https://core.telegram.org/bots/api-changelog
curl -fsS -o runtime/bot-api-update/api.html https://core.telegram.org/bots/api
python3 .claude/skills/bot-api-update/scripts/telegram_page_to_md.py \
    runtime/bot-api-update/api-changelog.html runtime/bot-api-update/api-changelog.md
python3 .claude/skills/bot-api-update/scripts/telegram_page_to_md.py \
    runtime/bot-api-update/api.html runtime/bot-api-update/api.md
```

`api-changelog.md` says *what* changed; `api.md` (the full reference, several thousand lines — grep
it, never read it whole) gives the exact field names, types and optionality needed to write the
classes. Each type and method is a `#### <Name>` heading followed by one `| field | type |
description` line per field, so `sed -n '/^#### Foo$/,/^#### /p'` prints exactly one definition.

## 3. Is anything actually missing?

- Newest released version: the first `#### <date>` block in
  `runtime/bot-api-update/api-changelog.md`, whose first line is `**Bot API X.Y**`.
- Version the package supports: the line in `README.md` that reads
  `✔️ Telegram Bot API X.Y (<date>) is **fully supported**.`

If they match, the work is already done: tell the user that the package is up to date with
Bot API X.Y and **stop** — no branch, no plan, no commits.

If the package is behind by more than one release, cover every missing release in this run,
oldest first, in one plan.

Otherwise create the branch, named like the previous ones (`api102` for 10.2, `api10` for 10.0,
`api96` for 9.6 — `api` + the version digits without the dot):

```bash
git switch -c api103
```

## 4. Write the plan

Put the plan in `runtime/bot-api-update/plan.md` (gitignored — it is a working document, never
committed).

Split it as finely as it can reasonably be split. Rules for slicing:

- One new type class = one item. One new method class = one item.
- One new field on an existing type = one item; several new fields on the *same* type coming from
  the same changelog bullet may share one item.
- One changelog bullet that adds the same parameter to a dozen methods = one item (it is one
  logical change and one `CHANGELOG.md` line).
- A new interface plus its `ValueProcessor` and `ObjectFactory` registration = one item; each
  implementation of that interface is its own item.
- Every item covers its own tests. Tests are never a separate trailing item.
- Order items so dependencies come first (types before the methods that use them).

Close the plan with these fixed items:

1. Update the supported-version line in `README.md`.
2. Add the `CHANGELOG.md` entries.
3. `composer cs-fix` + `composer rector` (step 7).
4. Verification (step 8).

Item template:

```markdown
## Bot API 10.3

- [ ] 1. Add `EphemeralMessageParameters` type
      Changelog: Added the class EphemeralMessageParameters ...
      Files: src/Type/EphemeralMessageParameters.php, tests/Type/EphemeralMessageParametersTest.php
      Changelog entry: New: Add `EphemeralMessageParameters` type.
```

Cross-check the finished plan against the changelog bullets: every bullet of the target version
must be traceable to at least one item, including "Supported ...", "Replaced ..." and
"Renamed ..." bullets, which are easy to miss.

The `CHANGELOG.md` entries reference a PR that does not exist yet: this skill never pushes the
branch and never opens a pull request — the user does that themselves once the work is reviewed.
Only the *number* is needed here, and it is the next free issue/PR number:

```bash
gh issue list --state all --limit 1 --json number
gh pr list --state all --limit 1 --json number
```

Take the larger number, add 1, and confirm that number with the user in step 5.

## 5. Agree the plan with the user

Show the user the plan (summary plus the item list) and the PR number you intend to use, and ask
for confirmation or corrections. Do not start implementing before they answer. Apply whatever they
change to `runtime/bot-api-update/plan.md` first.

## 6. Implement, item by item

For each item, in order:

1. Implement the source change following `AGENTS.md` (backward compatibility is preserved; new
   constructor parameters go last with a default).
2. Write or extend the tests in the same step.
3. Run the affected tests: `vendor/bin/phpunit --filter=<TestClass>`.
4. Commit only the files of this item:
   ```bash
   git add <files>
   git commit -m "Add EphemeralMessageParameters type"
   ```
   English, imperative, one line — the PR is squashed, so these are working notes.
5. Mark the item `[x]` in `runtime/bot-api-update/plan.md`.

Never `git add -A` — `runtime/` is ignored, but stray files are not worth the risk. Never commit
anything under `runtime/`.

If an item turns out to be wrong or to need splitting, update `runtime/bot-api-update/plan.md` and
tell the user what changed, then continue.

## 7. cs-fix and rector

```bash
composer cs-fix
composer rector
composer test
```

Review the diff these tools produce before committing it — rector occasionally rewrites something
in a way that conflicts with the project style. Commit as `Apply cs-fix and rector`.

## 8. Verification

Report all four results to the user, honestly, with the actual output of anything that fails.

1. **Completeness.** Walk the changelog bullets of the target version one by one and confirm each
   is implemented in `src/`. Confirm every `[ ]` in `runtime/bot-api-update/plan.md` is now
   `[x]`.
2. **Tests.**
   ```bash
   composer test
   ```
3. **Coverage — must be 100%.**
   ```bash
   XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text   # or `composer coverage` for HTML
   ```
   If PHPUnit warns `No code coverage driver available` (the usual case in this environment —
   neither Xdebug nor PCOV is installed), say so plainly instead of claiming coverage. Then fall
   back to a manual check: every class added or changed in this branch
   (`git diff --stat master...HEAD -- src`) has a corresponding test that exercises the new code,
   including every new facade method in `src/TelegramBotApi.php`. Tell the user that CI
   (Coveralls) gives the authoritative number.
4. **Static analysis — must be clean.**
   ```bash
   composer psalm
   composer dependency-analyser
   ```

Finish with a short summary: version ported, number of commits, what each verification
step returned, and anything left open. Leave the branch local and unpushed — say that pushing it
and opening the PR is up to the user.
