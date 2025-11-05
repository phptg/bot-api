<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\NativeTransport\DownloadFileTo;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
use Phptg\BotApi\Tests\Transport\NativeTransport\StreamMock\StreamMock;
use Phptg\BotApi\Transport\NativeTransport;
use Yiisoft\Files\FileHelper;

use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertStringEqualsFile;

final class NativeTransportDownloadFileToTest extends TestCase
{
    private const RUNTIME_PATH = __DIR__ . '/runtime';

    protected function setUp(): void
    {
        FileHelper::removeDirectory(self::RUNTIME_PATH);
        FileHelper::ensureDirectory(self::RUNTIME_PATH);
    }

    public function testBase(): void
    {
        $transport = new NativeTransport();

        $filePath = self::RUNTIME_PATH . '/file.txt';

        StreamMock::enable(responseBody: 'hello-content');
        $transport->downloadFileTo('http://example.test/test.txt', $filePath);
        $request = StreamMock::disable();

        assertSame(
            [
                'path' => 'http://example.test/test.txt',
                'options' => [],
            ],
            $request,
        );
        assertFileExists($filePath);
        assertStringEqualsFile($filePath, 'hello-content');
    }

    public function testErrorOnSave(): void
    {
        $transport = new NativeTransport();
        $filePath = self::RUNTIME_PATH . '/non-exists/file.txt';

        StreamMock::enable(responseBody: 'hello-content');

        $exception = null;
        try {
            $transport->downloadFileTo('http://example.test/test.txt', $filePath);
        } catch (Throwable $exception) {
        } finally {
            StreamMock::disable();
        }

        assertInstanceOf(RuntimeException::class, $exception);
        assertStringContainsString('Failed to open stream: No such file or directory', $exception->getMessage());
    }
}
