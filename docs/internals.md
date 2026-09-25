# Internals

## Manual testing with real telegram bot API

- Open directory `/tests/RealTelegramApi/`.
- Copy `RealTelegramApiTest.dist.php` to `RealTelegramApiTest.php`.
- Add your bot authentication token to constant `TOKEN` in `RealTelegramApiTest.php`, for example:

```php
// ...
final class RealTelegramApiTest extends TestCase
{
    private const TOKEN = '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw';
// ...
```

- Put your test code into `testBase()` method in `RealTelegramApiTest.php`.
- Run tests with real Telegram bot API via PHPUnit:

```shell
./vendor/bin/phpunit --group=realApi
# or
composer test-real
```

## Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

## Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework. To run it:

```shell
composer infection
```

## Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## Code style

Package used [PHP CS Fixer](https://cs.symfony.com/) to maintain [PER CS 3.0](https://www.php-fig.org/per/coding-style/)
code style. To check and fix code style:

```shell
composer cs-fix
```

## Refactoring

The code is refactored with [Rector](https://getrector.com/). To apply it:

```shell
composer rector
```

## Dependencies

Use [Composer Dependency Analyser](https://github.com/shipmonk-rnd/composer-dependency-analyser) to detect unused,
shadow and misplaced [Composer](https://getcomposer.org) dependencies:

```shell
composer dependency-analyser
```
