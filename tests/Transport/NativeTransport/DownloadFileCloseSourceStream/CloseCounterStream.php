<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\NativeTransport\DownloadFileCloseSourceStream;

final class CloseCounterStream
{
    /**
     * @var resource|null
     */
    public $context;

    public static int $closeCount = 0;

    public function stream_open(string $path, string $mode, int $options, ?string &$opened_path): bool
    {
        return true;
    }

    public function stream_read(int $count): string
    {
        return 'test';
    }

    public function stream_write(string $data): int
    {
        return strlen($data);
    }

    public function stream_eof(): bool
    {
        return true;
    }

    public function stream_close(): void
    {
        self::$closeCount++;
    }

    public function stream_stat(): array|false
    {
        return false;
    }
}
