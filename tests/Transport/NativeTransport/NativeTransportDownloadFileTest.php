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

        StreamMock::enable(responseBody: 'hello-content');
        $result = $transport->downloadFile('http://example.test/test.txt');
        $request = StreamMock::disable();

        assertSame(
            [
                'path' => 'http://example.test/test.txt',
                'options' => [],
            ],
            $request,
        );
        assertSame('hello-content', $result);
    }

    public function testError(): void
    {
        $transport = new NativeTransport();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('file_get_contents(): Unable to find the wrapper "example"');
        $transport->downloadFile('example://example.test/test.txt');
    }
}
