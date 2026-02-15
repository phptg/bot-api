<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport\DownloadFileCloseSourceStream;

final class ErrorOnWriteStream
{
    /**
     * @var resource|null
     */
    public $context;

    public function stream_open(string $path, string $mode, int $options, ?string &$opened_path): bool
    {
        return true;
    }

    public function stream_write(string $data): int
    {
        trigger_error('Write error', E_USER_WARNING);
        return 0;
    }

    public function stream_eof(): bool
    {
        return false;
    }

    public function stream_close(): void
    {
    }

    public function stream_stat(): array|false
    {
        return false;
    }
}
