<?php

declare(strict_types=1);

namespace Transport\MimeTypeResolver;

use Generator;
use Phptg\BotApi\Transport\ResourceReader\NativeResourceReader;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\InputFileData;
use Phptg\BotApi\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\CompositeMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\CustomMimeTypeResolver;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertSame;

final class CompositeMimeTypeResolverTest extends TestCase
{
    public static function dataResolve(): Generator
    {
        $readers = [new NativeResourceReader()];

        yield 'custom resolver takes priority' => [
            'text/my-plain',
            new InputFileData(InputFile::fromLocalFile(__DIR__ . '/files/test.txt'), $readers),
        ];
        yield 'fallback to apache resolver' => [
            'image/png',
            new InputFileData(InputFile::fromLocalFile(__DIR__ . '/files/dot.png'), $readers),
        ];
        yield 'unknown extension returns null' => [
            null,
            new InputFileData(InputFile::fromLocalFile(__DIR__ . '/files/test.unknown'), $readers),
        ];
    }

    #[DataProvider('dataResolve')]
    public function testResolve(?string $expected, InputFileData $inputFileData): void
    {
        $resolver = new CompositeMimeTypeResolver(
            new CustomMimeTypeResolver(['txt' => 'text/my-plain']),
            new ApacheMimeTypeResolver(),
        );

        assertSame($expected, $resolver->resolve($inputFileData));
    }
}
