<div align="center">
    <a href="https://github.com/phptg">
        <img src="logo.png" alt="PHPTG">
    </a>
    <h1 align="center">Telegram Bot API for PHP</h1>
    <br>
</div>

[![Latest Stable Version](https://poser.pugx.org/phptg/bot-api/v)](https://packagist.org/packages/phptg/bot-api)
[![Total Downloads](https://poser.pugx.org/phptg/bot-api/downloads)](https://packagist.org/packages/phptg/bot-api)
[![Build status](https://github.com/phptg/bot-api/actions/workflows/build.yml/badge.svg)](https://github.com/phptg/bot-api/actions/workflows/build.yml)
[![Coverage Status](https://coveralls.io/repos/github/phptg/bot-api/badge.svg)](https://coveralls.io/github/phptg/bot-api)
[![Mutation score](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fphptg%2Fbot-api%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/phptg/bot-api/master)
[![Static analysis](https://github.com/phptg/bot-api/actions/workflows/static.yml/badge.svg?branch=master)](https://github.com/phptg/bot-api/actions/workflows/static.yml?query=branch%3Amaster)

The package provides a simple and convenient way to interact with the Telegram Bot API.

✔️ Telegram Bot API 9.2 (August 15, 2025) is **fully supported**.

## Requirements

- PHP (64-bit) 8.2 - 8.5.

## Installation

The package can be installed with [Composer](https://getcomposer.org/download/):

```shell
composer require phptg/bot-api
```

## General usage

To make requests to the Telegram Bot API, you need to create an instance of the `TelegramBotApi` class.

```php
use Phptg\BotApi\TelegramBotApi;

// API
$api = new TelegramBotApi(
    // Telegram bot authentication token
    '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw',
);
```

Now you can use the `$api` instance to interact with the Telegram Bot API. Method names are the same as in 
the [Telegram Bot API documentation](https://core.telegram.org/bots/api). For example:

```php
use Phptg\BotApi\Type\InputFile

// Specify a URL for outgoing webhook
$api->setWebhook('https://example.com/webhook');

// Send text message
$api->sendMessage(
    chatId: 22351, 
    text: 'Hello, world!',
);

// Send local photo
$api->sendPhoto(
    chatId: 22351, 
    photo: InputFile::fromLocalFile('/path/to/photo.jpg'),
);
```

The result will be either a `FailResult` instance (occurring on an error) or an object of the corresponding type 
(occurring on success). For example:

```php
// Result is an array of `Phptg\BotApi\Update\Update` objects
$updates = $api->getUpdates();
```

## Documentation

### `TelegramBotApi`

`TelegramBotApi` constructor parameters:

- `$token` (required) — Telegram bot authentication token;
- `$baseUrl` — the base URL for Telegram Bot API requests (default `https://api.telegram.org`).
- `$transport` — the [transport](docs/transport.md) to make requests to Telegram Bot API ([cURL](docs/transport.md#curl)
  or [native](docs/transport.md#native) transport will be used by default).
- `$logger` — the [PSR-3](https://www.php-fig.org/psr/psr-3/) compatible logger to log requests to Telegram Bot API and
  response handling errors. See [logging](docs/logging.md) for more information.

Method names are the same as in the [Telegram Bot API documentation](https://core.telegram.org/bots/api).

### Files

#### File URL

Use `TelegramBotApi::makeFileUrl()` method to make a URL for downloading a file from the Telegram server. For example:

```php
/**
 * @var \Phptg\BotApi\TelegramBotApi $api
 * @var \Phptg\BotApi\Type\File $file 
 */
 
// By `File` instance
$url = $api->makeFileUrl($file);

// By file path is taken from the Telegram response
$url = $api->makeFileUrl('photos/file_2');
```

#### File downloading

Use `TelegramBotApi::downloadFile()` and `TelegramBotApi::downloadFileTo()` methods to download a file from the Telegram
server. For example:

```php
/**
 * @var \Phptg\BotApi\TelegramBotApi $api
 * @var \Phptg\BotApi\Type\File $file
 */
 
// Get file content by `File` instance
$fileContent = $api->downloadFile($file);

// Get file content by file path
$fileContent = $api->downloadFile('photos/file_2');

// Download and save file by `File` instance
$fileContent = $api->downloadFileTo($file, '/local/path/to/file.jpg');

// Download and save file by file path
$fileContent = $api->downloadFileTo('photos/file_2', '/local/path/to/file.jpg');
```

### Guides

- [Transport](docs/transport.md)
- [Logging](docs/logging.md)
- [Webhook handling](docs/webhook-handling.md)
- [Custom requests](docs/custom-requests.md)
- [Internals](docs/internals.md)

If you have any questions or problems with this package, use [author telegram chat](https://t.me/predvoditelev_chat) for communication.

## License

The `phptg/bot-api` is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

## Credits

The package is inspired by [Botasis](https://github.com/botasis) code originally created 
by [Viktor Babanov](https://github.com/viktorprogger).
