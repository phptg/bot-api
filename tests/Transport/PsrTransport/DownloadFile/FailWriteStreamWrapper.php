<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\PsrTransport\DownloadFile;

final class FailWriteStreamWrapper
{
    /** @var resource */
    public $context;

    public function stream_open(): bool
    {
        return true;
    }

    public function stream_write(): false
    {
        return false;
    }
}
