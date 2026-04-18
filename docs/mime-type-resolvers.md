# MIME type resolvers

MIME type resolvers determine the content type of files sent to the Telegram Bot API. The transport uses a resolver
to set the correct `Content-Type` for each file.

## Built-in resolvers

- `ApacheMimeTypeResolver` — resolves MIME type by file extension based on
  [Apache's `mime.types` file](https://svn.apache.org/repos/asf/httpd/httpd/tags/2.4.9/docs/conf/mime.types). Used by
  default.
- `CustomMimeTypeResolver` — resolves MIME type by file extension using a custom map.
- `CompositeMimeTypeResolver` — combines multiple resolvers, returning the first non-null result.

## Custom MIME type resolvers

You can create a custom resolver by implementing `MimeTypeResolverInterface`:

```php
use Phptg\BotApi\Transport\MimeTypeResolver\MimeTypeResolverInterface;
use Phptg\BotApi\Type\InputFile;

final class MyMimeTypeResolver implements MimeTypeResolverInterface
{
    public function resolve(InputFile $inputFile): ?string
    {
        // Return MIME type or null if it cannot be determined
        return null;
    }
}
```

Pass it to the transport constructor:

```php
use Phptg\BotApi\TelegramBotApi;
use Phptg\BotApi\Transport\NativeTransport;

$transport = new NativeTransport(
    mimeTypeResolver: new MyMimeTypeResolver(),
);

$api = new TelegramBotApi($token, transport: $transport);
```

## Combining resolvers

To combine multiple resolvers use `CompositeMimeTypeResolver`:

```php
use Phptg\BotApi\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\CompositeMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\CustomMimeTypeResolver;
use Phptg\BotApi\Transport\NativeTransport;

$transport = new NativeTransport(
    mimeTypeResolver: new CompositeMimeTypeResolver(
        new CustomMimeTypeResolver(['webp' => 'image/webp']),
        new ApacheMimeTypeResolver(),
    ),
);
```
