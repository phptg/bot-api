<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsResource;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputFileTest extends TestCase
{
    public function testBase(): void
    {
        $stream = (new StreamFactory())->createStream('test');
        $file = new InputFile($stream);

        assertSame($stream, $file->resource);
        assertNull($file->filename);
    }

    public function testFilled(): void
    {
        $stream = (new StreamFactory())->createStream('test');
        $file = new InputFile($stream, 'file.txt');

        assertSame($stream, $file->resource);
        assertSame('file.txt', $file->filename);
    }

    public function testFromLocalFile(): void
    {
        $file = InputFile::fromLocalFile(__FILE__);

        assertIsResource($file->resource);
        assertNull($file->filename);
    }

    public function testFromLocalFileWithName(): void
    {
        $file = InputFile::fromLocalFile(__FILE__, 'test.php');

        assertIsResource($file->resource);
        assertSame('test.php', $file->filename);
    }

    public function testFromLocalNotExistsFile(): void
    {
        $errorMessage = null;
        set_error_handler(
            static function (int $code, string $message) use (&$errorMessage): bool {
                $errorMessage = $message;
                return true;
            },
        );

        $exception = null;
        try {
            InputFile::fromLocalFile('not-exists');
        } catch (Throwable $exception) {
        }

        restore_error_handler();

        assertSame('fopen(not-exists): Failed to open stream: No such file or directory', $errorMessage);
        assertInstanceOf(RuntimeException::class, $exception);
        assertSame('Unable to open file "not-exists".', $exception->getMessage());
    }
}
