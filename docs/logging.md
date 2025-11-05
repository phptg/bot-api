# Logging

You can use any [PSR-3](https://www.php-fig.org/psr/psr-3/) compatible logger to log requests to Telegram Bot API and
response handling errors. For example, [Monolog](https://github.com/Seldaek/monolog) or
[Yii Log](https://github.com/yiisoft/log).

## General usage

Pass logger to `TelegramBotApi` constructor:

```php
use Psr\Log\LoggerInterface;
use Phptg\BotApi\TelegramBotApi;

/**
 * @var string $token
 * @var LoggerInterface $logger
 */

// API
$api = new TelegramBotApi($token, logger: $logger);
```

You can use logger on create `Update` object also:

```php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Phptg\BotApi\Type\Update\Update;

/**
 * @var ServerRequestInterface $request
 * @var string $jsonString
 * @var LoggerInterface $logger
 */

$update = Update::fromServerRequest($request, $logger);
$update = Update::fromJson($jsonString, $logger);
```

## Log context

To logger passed 4 types of messages.

1) On send request `info` message with context:

```php
[
    'type' => LogType::SEND_REQUEST,
    'payload' => $payload, // Request data as array with string keys
    'method' => $method, // `MethodInterface` implementation
]
```

2) On success result `info` message with context:

```php
[
    'type' => LogType::SUCCESS_RESULT,
    'payload' => $payload, // Decoded response body as array
    'method' => $method, // `MethodInterface` implementation
    'response' => $response, // `ApiResponse` object
    'decodedResponse' => $decodedResponse, // Decoded response body as array 
]
```

3) On fail result `warning` message with context:

```php
[
    'type' => LogType::FAIL_RESULT,
    'payload' => $payload, // Response body as string
    'method' => $method, // `MethodInterface` implementation
    'response' => $response, // `ApiResponse` object
    'decodedResponse' => $decodedResponse, // Decoded response body as array 
]
```

4) On parse result error `error` message with context:

```php
[
    'type' => LogType::PARSE_RESULT_ERROR,
    'payload' => $payload, // Raw parsed data as string
]
```
