<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\CurlTransport;

use CurlShareHandle;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
use Phptg\BotApi\Curl\CurlException;
use Phptg\BotApi\Tests\Curl\CurlMock;
use Phptg\BotApi\Transport\CurlTransport;
use Phptg\BotApi\Transport\DownloadFileException;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class CurlTransportDownloadFileTest extends TestCase
{
    public function testBase(): void
    {
        $curl = new CurlMock('hello-content');
        $transport = new CurlTransport(curl: $curl);

        $stream = fopen('php://temp', 'r+b');
        $transport->downloadFile('https://example.test/hello.jpg', $stream);
        rewind($stream);

        assertSame('hello-content', stream_get_contents($stream));

        $options = $curl->getOptions();
        assertCount(4, $options);
        assertSame('https://example.test/hello.jpg', $options[CURLOPT_URL]);
        assertSame($stream, $options[CURLOPT_FILE]);
        assertTrue($options[CURLOPT_FAILONERROR]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);
    }

    public function testInitException(): void
    {
        $initException = new CurlException('test');
        $curl = new CurlMock(initException: $initException);
        $transport = new CurlTransport(curl: $curl);
        $stream = fopen('php://temp', 'r+b');

        $exception = null;
        try {
            $transport->downloadFile('https://example.test/hello.jpg', $stream);
        } catch (Throwable $exception) {
        }

        assertInstanceOf(DownloadFileException::class, $exception);
        assertSame('test', $exception->getMessage());
        assertSame($initException, $exception->getPrevious());
    }

    public function testExecException(): void
    {
        $execException = new CurlException('test');
        $curl = new CurlMock(execResult: $execException);
        $transport = new CurlTransport(curl: $curl);
        $stream = fopen('php://temp', 'r+b');

        $exception = null;
        try {
            $transport->downloadFile('https://example.test/hello.jpg', $stream);
        } catch (Throwable $exception) {
        }

        assertInstanceOf(DownloadFileException::class, $exception);
        assertSame('test', $exception->getMessage());
        assertSame($execException, $exception->getPrevious());
    }

    public function testCloseOnException(): void
    {
        $curl = new CurlMock(new RuntimeException());
        $transport = new CurlTransport(curl: $curl);
        $stream = fopen('php://temp', 'r+b');

        try {
            $transport->downloadFile('https://example.test/hello.jpg', $stream);
        } catch (Throwable) {
        }

        assertSame(1, $curl->getCountCallOfClose());
    }
}
