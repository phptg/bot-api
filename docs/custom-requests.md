# Custom requests

You can make custom requests to API using the `call()` method and `CustomMethod` object:

```php
use Phptg\BotApi\CustomMethod;
use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;

/** 
 * @var \Phptg\BotApi\TelegramBotApi $api 
 */

$method = new CustomMethod(
    apiMethod: 'getChat',
    data: ['chat_id' => '@sergei_predvoditelev'],
    resultType: new ObjectValue(ChatFullInfo::class),
    httpMethod: HttpMethod::GET,
);

// Result is an object of `Phptg\BotApi\Type\ChatFullInfo`
$result = $api->call($method);
```
