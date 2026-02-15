<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\NativeTransport\DownloadFileCloseSourceStream;

use Phptg\BotApi\Transport\DownloadFileException;
use Phptg\BotApi\Transport\NativeTransport;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

final class DownloadFileCloseSourceStreamTest extends TestCase
{
    protected function setUp(): void
    {
        stream_wrapper_register('error-on-write', ErrorOnWriteStream::class);
        stream_wrapper_register('close-counter', CloseCounterStream::class);
        CloseCounterStream::$closeCount = 0;
    }

    protected function tearDown(): void
    {
        stream_wrapper_unregister('error-on-write');
        stream_wrapper_unregister('close-counter');
    }

    public function testBase(): void
    {
        $transport = new NativeTransport();
        $stream = fopen('error-on-write://test', 'wb');

        try {
            $transport->downloadFile('close-counter://test', $stream);
        } catch (DownloadFileException) {
        }

        assertSame(1, CloseCounterStream::$closeCount);
    }
}
