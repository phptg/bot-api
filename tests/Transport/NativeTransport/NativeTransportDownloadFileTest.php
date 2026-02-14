<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\NativeTransport;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Phptg\BotApi\Tests\Transport\NativeTransport\StreamMock\StreamMock;
use Phptg\BotApi\Transport\NativeTransport;

use function PHPUnit\Framework\assertSame;

final class NativeTransportDownloadFileTest extends TestCase
{
    public function testBase(): void
    {
        $transport = new NativeTransport();

        $stream = fopen('php://temp', 'r+b');

        StreamMock::enable(responseBody: 'hello-content');
        $transport->downloadFile('http://example.test/test.txt', $stream);
        $request = StreamMock::disable();
        rewind($stream);

        assertSame(
            [
                'path' => 'http://example.test/test.txt',
                'options' => [],
            ],
            $request,
        );
        assertSame('hello-content', stream_get_contents($stream));
    }

    public function testError(): void
    {
        $transport = new NativeTransport();
        $stream = fopen('php://temp', 'r+b');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('fopen(): Unable to find the wrapper "example"');
        $transport->downloadFile('example://example.test/test.txt', $stream);
    }
}
