<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\NativeTransport\StreamMock;

use RuntimeException;

use function is_array;
use function is_string;
use function strlen;

final class StreamMock
{
    private const CONFIG_FILE = __DIR__ . '/stream-mock-config.json';
    private const REQUEST_FILE = __DIR__ . '/stream-mock-result.data';

    /**
     * @var array{
     *     responseHeaders: list<string>,
     *     responseBody: string,
     * }
     */
    private array $config;

    private int $position = 0;

    /**
     * @var resource
     */
    // @phpstan-ignore shipmonk.deadProperty.neverWritten (the property is set by PHP when the class is used as a stream wrapper)
    public $context;

    public function __construct()
    {
        $config = json_decode(self::readFile(self::CONFIG_FILE), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($config)
            || !is_array($config['responseHeaders'] ?? null)
            || !is_string($config['responseBody'] ?? null)
        ) {
            throw new RuntimeException('Invalid stream mock config.');
        }

        $responseHeaders = [];
        foreach ($config['responseHeaders'] as $header) {
            if (!is_string($header)) {
                throw new RuntimeException('Invalid stream mock config.');
            }
            $responseHeaders[] = $header;
        }

        $this->config = [
            'responseHeaders' => $responseHeaders,
            'responseBody' => $config['responseBody'],
        ];
    }

    /**
     * @param list<string> $responseHeaders
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

    /**
     * @return array{path: string, options: array<string, array<mixed>>}|null
     */
    public static function disable(): ?array
    {
        stream_wrapper_restore('http');

        if (!file_exists(self::REQUEST_FILE)) {
            return null;
        }

        $request = unserialize(self::readFile(self::REQUEST_FILE));
        if (!is_array($request)
            || !is_string($request['path'] ?? null)
            || !is_array($request['options'] ?? null)
        ) {
            throw new RuntimeException('Invalid stream mock request.');
        }

        $options = [];
        foreach ($request['options'] as $wrapper => $wrapperOptions) {
            if (!is_string($wrapper) || !is_array($wrapperOptions)) {
                throw new RuntimeException('Invalid stream mock request.');
            }
            $options[$wrapper] = $wrapperOptions;
        }

        return [
            'path' => $request['path'],
            'options' => $options,
        ];
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

    /**
     * @return array<int|string, int>
     */
    public function stream_stat(): array
    {
        return [];
    }

    public function stream_close(): void
    {
        global $http_response_header;
        $http_response_header = $this->config['responseHeaders'];
    }

    private static function readFile(string $path): string
    {
        $content = file_get_contents($path);
        if ($content === false) {
            throw new RuntimeException('Failed to read "' . $path . '".');
        }
        return $content;
    }
}
