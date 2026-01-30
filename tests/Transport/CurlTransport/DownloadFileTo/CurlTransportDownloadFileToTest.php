<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\CurlTransport\DownloadFileTo;

use CurlShareHandle;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
use Phptg\BotApi\Curl\CurlException;
use Phptg\BotApi\Tests\Curl\CurlMock;
use Phptg\BotApi\Transport\CurlTransport;
use Phptg\BotApi\Transport\DownloadFileException;
use Phptg\BotApi\Transport\SaveFileException;
use Yiisoft\Files\FileHelper;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsResource;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertStringEqualsFile;
use function PHPUnit\Framework\assertTrue;

final class CurlTransportDownloadFileToTest extends TestCase
{
    private const RUNTIME_PATH = __DIR__ . '/runtime';

    protected function setUp(): void
    {
        FileHelper::removeDirectory(self::RUNTIME_PATH);
        FileHelper::ensureDirectory(self::RUNTIME_PATH);
    }

    public function testBase(): void
    {
        $curl = new CurlMock('hello-content');
        $transport = new CurlTransport(curl: $curl);

        $filePath = self::RUNTIME_PATH . '/file.txt';

        $transport->downloadFileTo('https://example.test/test.txt', $filePath);

        $options = $curl->getOptions();
        assertCount(4, $options);
        assertSame('https://example.test/test.txt', $options[CURLOPT_URL]);
        assertIsResource($options[CURLOPT_FILE]);
        assertTrue($options[CURLOPT_FAILONERROR]);
        assertInstanceOf(CurlShareHandle::class, $options[CURLOPT_SHARE]);

        assertFileExists($filePath);
        assertStringEqualsFile($filePath, 'hello-content');
    }

    public function testErrorOnFopen(): void
    {
        $filePath = self::RUNTIME_PATH . '/test.txt';
        touch($filePath);
        chmod($filePath, 0444);
        assertFileExists($filePath);

        $transport = new CurlTransport(curl: new CurlMock());

        $this->expectException(SaveFileException::class);
        $this->expectExceptionMessage('Failed to open stream: Permission denied');
        $transport->downloadFileTo('https://example.test/test.txt', $filePath);
    }

    public function testInitException(): void
    {
        $initException = new CurlException('test');
        $curl = new CurlMock(initException: $initException);
        $transport = new CurlTransport(curl: $curl);

        $exception = null;
        try {
            $transport->downloadFileTo(
                'https://example.test/hello.jpg',
                self::RUNTIME_PATH . '/init-exception.txt',
            );
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

        $exception = null;
        try {
            $transport->downloadFileTo(
                'https://example.test/hello.jpg',
                self::RUNTIME_PATH . '/exec-exception.txt',
            );
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

        try {
            $transport->downloadFileTo(
                'https://example.test/hello.jpg',
                self::RUNTIME_PATH . '/close-on-exception.txt',
            );
        } catch (Throwable) {
        }

        assertSame(1, $curl->getCountCallOfClose());
    }
}
