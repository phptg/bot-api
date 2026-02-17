<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\DownloadedFile\SaveTo;

use Phptg\BotApi\DownloadedFile;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertSame;

final class SaveToTest extends TestCase
{
    private const FILE = __DIR__ . '/test.txt';

    public function testSaveTo(): void
    {
        if (file_exists(self::FILE)) {
            unlink(self::FILE);
        }

        $stream = fopen('php://temp', 'r+b');
        fwrite($stream, 'hello-content');
        rewind($stream);

        $file = new DownloadedFile($stream);

        $file->saveTo(self::FILE);

        assertFileExists(self::FILE);
        assertSame('hello-content', file_get_contents(self::FILE));
    }
}
