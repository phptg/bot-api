<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertNotFalse;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputFileTest extends TestCase
{
    public function testFromPath(): void
    {
        $file = new InputFile(__FILE__);

        assertSame(__FILE__, $file->pathOrResource);
        assertSame(basename(__FILE__), $file->filename());
        assertSame('php', $file->extension());
    }

    public function testFromPathWithFilename(): void
    {
        $file = new InputFile(__FILE__, 'test.txt');

        assertSame(__FILE__, $file->pathOrResource);
        assertSame('test.txt', $file->filename());
        assertSame('txt', $file->extension());
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function dataFromResource(): iterable
    {
        // PHP recognizes `file://` URIs with a host only when the path uses forward slashes on Windows.
        $path = str_replace('\\', '/', __FILE__);
        yield 'plain path' => [$path];
        yield 'file URI' => ['file://' . $path];
        yield 'file URI with localhost host' => ['file://localhost' . $path];
        yield 'file URI in uppercase' => ['FILE://LOCALHOST' . $path];
    }

    #[DataProvider('dataFromResource')]
    public function testFromResource(string $uri): void
    {
        $resource = TestHelper::openFile($uri, 'rb');
        $file = new InputFile($resource);

        assertSame($resource, $file->pathOrResource);
        assertSame(basename(__FILE__), $file->filename());
        assertSame('php', $file->extension());

        fclose($resource);
    }

    public function testFromTmpFile(): void
    {
        $resource = tmpfile();
        assertNotFalse($resource);

        $uri = stream_get_meta_data($resource)['uri'] ?? null;
        assertNotNull($uri);

        $file = new InputFile($resource);
        assertSame(basename($uri), $file->filename());

        fclose($resource);
    }

    #[TestWith(['php://temp', 'r+b'])]
    #[TestWith(['data://text/plain,hi', 'r'])]
    public function testFromVirtualResource(string $uri, string $mode): void
    {
        $resource = TestHelper::openFile($uri, $mode);
        $file = new InputFile($resource);

        assertNull($file->filename());
        assertNull($file->extension());

        fclose($resource);
    }

    public function testFromResourceWithoutUri(): void
    {
        [$resource, $pair] = TestHelper::createSocketPair();
        $file = new InputFile($resource);

        assertNull($file->filename());
        assertNull($file->extension());

        fclose($resource);
        fclose($pair);
    }

    public function testFromResourceWithFilename(): void
    {
        $resource = TestHelper::openFile('php://temp', 'r+b');
        $file = new InputFile($resource, 'document.pdf');

        assertSame('document.pdf', $file->filename());
        assertSame('pdf', $file->extension());

        fclose($resource);
    }
}
