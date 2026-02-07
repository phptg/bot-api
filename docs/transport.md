# Transport

By default `TelegramBotApi` uses cURL to make requests to the Telegram Bot API and download files from Telegram servers.
But you can use any other transport implementation that implements
the `Phptg\BotApi\Transport\TransportInterface` interface.

Out of the box, available two transport implementations: cURL and native.

## cURL

The `CurlTransport` class is a transport implementation for making requests to the Telegram Bot API using
the [cURL](https://www.php.net/manual/book.curl.php) extension in PHP. This transport is often the easiest choice
since the cURL extension is included in most PHP installations.

General usage:

```php
use Phptg\BotApi\TelegramBotApi;
use Phptg\BotApi\Transport\CurlTransport;

// Telegram bot authentication token
$token = '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw';

$transport = new CurlTransport();

$api = new TelegramBotApi($token, transport: $transport);
```

Constructor parameters:

- `$resourceReaders` — list of [resource readers](resource-readers.md) to handle different resource types. By default,
  includes `NativeResourceReader`.

## Native

The `NativeTransport` uses native PHP functions `file_get_contents()` and `file_put_contents()` to make requests to
the Telegram Bot API and not require any additional extensions.

> Note: `NativeTransport` requires that
> [`allow_url_fopen`](https://www.php.net/manual/en/filesystem.configuration.php#ini.allow-url-fopen) option be
> enabled.

General usage:

```php
use Phptg\BotApi\TelegramBotApi;
use Phptg\BotApi\Transport\NativeTransport;

// Telegram bot authentication token
$token = '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw';

$transport = new NativeTransport();

$api = new TelegramBotApi($token, transport: $transport);
```

Constructor parameters:

- `$mimeTypeResolver` — MIME type resolver for determining file types. Defaults to `ApacheMimeTypeResolver`.
- `$resourceReaders` — List of [resource readers](resource-readers.md) to handle different resource types. By default,
  includes `NativeResourceReader`.

Available MIME type resolvers:

- `ApacheMimeTypeResolver` - based on file extension and
  [Apache's `mime.types` file](https://svn.apache.org/repos/asf/httpd/httpd/tags/2.4.9/docs/conf/mime.types) (uses
  by default);
- `CustomMimeTypeResolver` - based on file extension and custom MIME types map;
- `CompositeMimeTypeResolver` - allows to combine multiple resolvers into one.
