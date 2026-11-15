# Limits

The Telegram Bot API has limits on the number of messages a bot can send. Exceeding them results in 429
"Too Many Requests" errors. The limits depend on the chat the message is sent to: a single chat, a group
or a bulk notification to all the bot's subscribers. See
[Broadcasting to Users](https://core.telegram.org/bots/faq#broadcasting-to-users) in the Telegram Bots FAQ
for the exact values.

The bulk notification limit can be increased with paid broadcasts: the feature is enabled in `@BotFather`, and
each message over the free amount costs Telegram Stars withdrawn from the bot's balance. To allow such sending,
pass `true` as the `allowPaidBroadcast` parameter of a send method:

```php
$api->sendMessage('Hello!', $chatId, allowPaidBroadcast: true);
```

Bots with increased limits are only charged for messages that are broadcasted successfully. See
[Paid Broadcasts](https://core.telegram.org/bots/api#paid-broadcasts) in the Telegram Bot API documentation.

## Detecting a rate limit in the package

The package does not throw an exception on a 429 error — a request that hits a rate limit returns
a `FailResult` instance with:

- `errorCode` — `429`;
- `parameters` — a `Phptg\BotApi\Type\ResponseParameters` object, whose `retryAfter` field contains
  the number of seconds left to wait before the request can be repeated.

## Example of sending messages to all subscribers

Sending messages in a loop with pauses is acceptable for small scripts, but in a real application such a loop
blocks the process it runs in. The common solution is a queue: put each message into a queue (a database table,
Redis, RabbitMQ, etc.) and send them from a background worker.

Producer side:

```php
/**
 * @var object $queue Any queue implementation
 * @var int[] $chatIds Identifiers of chats with all the bot's subscribers
 */

foreach ($chatIds as $chatId) {
    $queue->push(['chatId' => $chatId, 'text' => 'Hello!']);
}
```

Worker side:

```php
use Phptg\BotApi\FailResult;
use Phptg\BotApi\TelegramBotApi;

/**
 * @var TelegramBotApi $api
 * @var object $queue Any queue implementation
 */

while ($task = $queue->take()) {
    $result = $api->sendMessage($task['text'], $task['chatId']);

    if ($result instanceof FailResult && $result->errorCode === 429) {
        // Return the task to the queue to retry after the delay Telegram asks for
        $queue->push($task, delayInSeconds: $result->parameters?->retryAfter ?? 1);
        continue;
    }

    if ($result instanceof FailResult) {
        // Handle another error, e.g. log it and mark the task as failed
    }
}
```

The worker must take tasks at a rate allowed by the limits. Many queue implementations support rate limiting
and delayed execution out of the box, so the `retryAfter` delay returned with a 429 error can be applied
without waiting in the worker process itself.
