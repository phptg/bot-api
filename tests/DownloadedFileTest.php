<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\DownloadedFile;
use Phptg\BotApi\SaveFileException;

use function PHPUnit\Framework\assertSame;

final class DownloadedFileTest extends TestCase
{
    public function testGetStream(): void
    {
        $stream = fopen('php://temp', 'r+b');
        fwrite($stream, 'hello');
        rewind($stream);

        $file = new DownloadedFile($stream);

        assertSame($stream, $file->getStream());
    }

    public function testGetBody(): void
    {
        $stream = fopen('php://temp', 'r+b');
        fwrite($stream, 'hello-content');
        rewind($stream);

        $file = new DownloadedFile($stream);

        assertSame('hello-content', $file->getBody());
    }

    public function testSaveTo(): void
    {
        $stream = fopen('php://temp', 'r+b');
        fwrite($stream, 'hello-content');
        rewind($stream);

        $file = new DownloadedFile($stream);

        $path = sys_get_temp_dir() . '/downloaded-file-test-' . uniqid(more_entropy: true) . '.txt';
        try {
            $file->saveTo($path);
            assertSame('hello-content', file_get_contents($path));
        } finally {
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    public function testSaveToError(): void
    {
        $stream = fopen('php://temp', 'r+b');
        $file = new DownloadedFile($stream);

        $this->expectException(SaveFileException::class);
        $file->saveTo(__DIR__ . '/non-existent-directory/file.txt');
    }
}
