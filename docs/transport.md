# Transport

By default `TelegramBotApi` uses cURL to make requests to the Telegram Bot API and download files from Telegram servers.
But you can use any other transport implementation that implements
the `Phptg\BotApi\Transport\TransportInterface` interface.

Out of the box, available three transport implementations: cURL, native and PSR.

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

Native transport uses instance of `MimeTypeResolverInterface` passed through the constructor for resolving MIME types
when build API request with files. 

Available resolvers:

- `ApacheMimeTypeResolver` - based on file extension and 
  [Apache's `mime.types` file](https://svn.apache.org/repos/asf/httpd/httpd/tags/2.4.9/docs/conf/mime.types) (uses 
  by default);
- `CustomMimeTypeResolver` - based on file extension and custom MIME types map;
- `CompositeMimeTypeResolver` - allows to combine multiple resolvers into one.

## PSR

PSR transport requires the [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP client and [PSR-17](https://www.php-fig.org/psr/psr-17/) HTTP factories.

For example, you can use the [php-http/curl-client](https://github.com/php-http/curl-client) and [httpsoft/http-message](https://github.com/httpsoft/http-message):

```shell
composer require php-http/curl-client httpsoft/http-message
```

General usage:

```php
use Http\Client\Curl\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use Phptg\BotApi\TelegramBotApi;
use Phptg\BotApi\Transport\PsrTransport;

$streamFactory = new StreamFactory();
$responseFactory = new ResponseFactory();
$requestFactory = new RequestFactory();
$client = new Client($responseFactory, $streamFactory);

// Telegram bot authentication token
$token = '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw';

$transport = new PsrTransport(
    $client,
    $requestFactory,
    $streamFactory,
);

$api = new TelegramBotApi($token, transport: $transport);
```

Constructor parameters:

- `$client` — PSR-18 HTTP client;
- `$requestFactory` — PSR-17 HTTP request factory;
- `$streamFactory` — PSR-17 HTTP stream factory;

