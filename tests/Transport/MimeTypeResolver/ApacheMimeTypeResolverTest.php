<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\MimeTypeResolver;

use Phptg\BotApi\Transport\InputFileData;
use Phptg\BotApi\Transport\ResourceReader\NativeResourceReader;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertSame;

final class ApacheMimeTypeResolverTest extends TestCase
{
    public static function dataBase(): iterable
    {
        yield [null, InputFile::fromLocalFile(__DIR__ . '/files/test.unknown')];
        yield ['text/plain', InputFile::fromLocalFile(__DIR__ . '/files/test.txt')];
        yield ['text/css', InputFile::fromLocalFile(__DIR__ . '/files/test.txt', 'test.css')];
        yield ['text/css', InputFile::fromLocalFile(__DIR__ . '/files/test.txt', 'test.CSS')];
    }

    #[DataProvider('dataBase')]
    public function testBase(?string $expected, InputFile $file): void
    {
        $resolver = new ApacheMimeTypeResolver();
        $fileData = new InputFileData($file, [new NativeResourceReader()]);

        $result = $resolver->resolve($fileData);

        assertSame($expected, $result);
    }
}
