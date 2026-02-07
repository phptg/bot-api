# Resource readers

Resource readers are components that handle reading content from different types of resources stored in `InputFile`
objects. When you send a file using `InputFile`, the transport internally iterates through the provided resource readers
and uses the first one that supports the resource type.

## Built-in readers

The package provides one built-in resource reader:

- `NativeResourceReader` — handles native PHP stream resources created by functions like `fopen()`, `tmpfile()`, etc.

## Custom resource readers

You can create custom resource readers by implementing the `ResourceReaderInterface`. This is useful when you need
to support custom resource types.

Example:

```php
use Phptg\BotApi\Transport\ResourceReader\ResourceReaderInterface;

final class MyCustomResourceReader implements ResourceReaderInterface
{
    public function supports(mixed $resource): bool
    {
        return $resource instanceof MyCustomResource;
    }

    public function read(mixed $resource): string
    {
        return $resource->getContent();
    }

    public function getUri(mixed $resource): string
    {
        return $resource->getPath();
    }
}
```

Then pass it to the transport:

```php
use Phptg\BotApi\TelegramBotApi;
use Phptg\BotApi\Transport\CurlTransport;
use Phptg\BotApi\Transport\ResourceReader\NativeResourceReader;

$transport = new CurlTransport(
    resourceReaders: [
        new NativeResourceReader(),
        new MyCustomResourceReader(),
    ],
);

$api = new TelegramBotApi($token, transport: $transport);
```
