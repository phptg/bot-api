<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\DownloadedFile;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\DownloadedFile;

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
}
