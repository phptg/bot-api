<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\NativeTransport\StreamMock;

use function strlen;

final class StreamMock
{
    private const CONFIG_FILE = __DIR__ . '/stream-mock-config.json';
    private const REQUEST_FILE = __DIR__ . '/stream-mock-result.data';

    /**
     * @psalm-var array{
     *     responseHeaders: list<string>,
     *     responseBody: string,
     * }
     */
    private array $config;

    private int $position = 0;

    /**
     * @var resource
     */
    public $context;

    public function __construct()
    {
        $this->config = json_decode(
            file_get_contents(self::CONFIG_FILE),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
    }

    /**
     * @psalm-param list<string> $responseHeaders
     */
    public static function enable(array $responseHeaders = [], string $responseBody = ''): void
    {
        file_put_contents(
            self::CONFIG_FILE,
            json_encode(
                [
                    'responseHeaders' => $responseHeaders,
                    'responseBody' => $responseBody,
                ],
                JSON_THROW_ON_ERROR,
            ),
        );
        if (file_exists(self::REQUEST_FILE)) {
            unlink(self::REQUEST_FILE);
        }

        stream_wrapper_unregister('http');
        stream_wrapper_register('http', self::class, STREAM_IS_URL);
    }

    public static function disable(): ?array
    {
        stream_wrapper_restore('http');

        if (!file_exists(self::REQUEST_FILE)) {
            return null;
        }

        return unserialize(file_get_contents(self::REQUEST_FILE));
    }

    public function stream_open(string $path): bool
    {
        file_put_contents(
            self::REQUEST_FILE,
            serialize([
                'path' => $path,
                'options' => stream_context_get_options($this->context),
            ]),
        );
        return true;
    }

    public function stream_read(int $count): string
    {
        $data = substr($this->config['responseBody'], $this->position, $count);
        $this->position += strlen($data);
        return $data;
    }

    public function stream_eof(): bool
    {
        return $this->position >= strlen($this->config['responseBody']);
    }

    public function stream_stat(): array
    {
        return [];
    }

    public function stream_close(): void
    {
        global $http_response_header;
        $http_response_header = $this->config['responseHeaders'];
    }
}
