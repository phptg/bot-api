<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport\DownloadFile;

final class WarnWriteStreamWrapper
{
    /** @var resource */
    public $context;

    public function stream_open(): bool
    {
        return true;
    }

    public function stream_write(): int
    {
        trigger_error('Custom write error', E_USER_WARNING);
        return 0;
    }
}
