<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputFileTest extends TestCase
{
    public function testFromPath(): void
    {
        $file = new InputFile(__FILE__);

        assertSame(__FILE__, $file->pathOrResource);
        assertNull($file->sendName);
        assertSame(basename(__FILE__), $file->filename());
        assertSame('php', $file->extension());
    }

    public function testFromPathWithSendName(): void
    {
        $file = new InputFile(__FILE__, 'test.txt');

        assertSame(__FILE__, $file->pathOrResource);
        assertSame('test.txt', $file->sendName);
        assertSame('test.txt', $file->filename());
        assertSame('txt', $file->extension());
    }

    public function testFromResource(): void
    {
        $resource = fopen(__FILE__, 'rb');
        $file = new InputFile($resource);

        assertSame($resource, $file->pathOrResource);
        assertNull($file->sendName);
        assertSame(basename(__FILE__), $file->filename());
        assertSame('php', $file->extension());

        fclose($resource);
    }

    public function testFromVirtualResource(): void
    {
        $resource = fopen('php://temp', 'r+b');
        $file = new InputFile($resource);

        assertNull($file->sendName);
        assertNull($file->filename());
        assertNull($file->extension());

        fclose($resource);
    }

    public function testFromResourceWithSendName(): void
    {
        $resource = fopen('php://temp', 'r+b');
        $file = new InputFile($resource, 'document.pdf');

        assertSame('document.pdf', $file->sendName);
        assertSame('document.pdf', $file->filename());
        assertSame('pdf', $file->extension());

        fclose($resource);
    }
}
