# Contributing

Thank you for considering contributing to the `phptg/bot-api` library!

## Reporting issues

Bug reports and feature requests are welcome via [GitHub Issues](https://github.com/phptg/bot-api/issues).
Please include the library version, the PHP version, and a minimal snippet that reproduces the problem.
For questions and discussion, use the author's [Telegram chat](https://t.me/predvoditelev_chat).

## Development setup

Requirements: 64-bit PHP 8.2–8.5 and [Composer](https://getcomposer.org/download/).

Fork the repository, clone it and run `composer install`.

See [Internals](../docs/internals.md) for running tests, static analysis, code style and the other tools.

## Rules

- The library has **zero runtime dependencies** — nothing may be added to the `require` section of
  `composer.json`.
- Backward compatibility is preserved as much as possible. A new method parameter is always added **last**,
  with a default value, regardless of its position in the Telegram Bot API documentation.
- Tests live under `tests/`, mirroring the structure of `src/`.
- Every user-visible change needs a `CHANGELOG.md` entry under the topmost `under development` heading, in the
  form `- New #123: Add SendMessage method.`, where `#123` is the pull request number. Use `New` for new features,
  `Enh` for improvements, `Chg` for changes affecting existing usage, `Bug` for fixes.
- Update the documentation (`README.md`, `docs/`) when behavior or the public API changes.

## Pull requests

Keep pull requests focused on a single change and make sure all CI checks pass.
