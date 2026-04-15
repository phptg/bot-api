<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\MimeTypeResolver;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\CompositeMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\CustomMimeTypeResolver;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertSame;

final class CompositeMimeTypeResolverTest extends TestCase
{
    public static function dataResolve(): Generator
    {
        yield 'custom resolver takes priority' => [
            'text/my-plain',
            new InputFile(__DIR__ . '/files/test.txt'),
        ];
        yield 'fallback to apache resolver' => [
            'image/png',
            new InputFile(__DIR__ . '/files/dot.png'),
        ];
        yield 'unknown extension returns null' => [
            null,
            new InputFile(__DIR__ . '/files/test.unknown'),
        ];
    }

    #[DataProvider('dataResolve')]
    public function testResolve(?string $expected, InputFile $file): void
    {
        $resolver = new CompositeMimeTypeResolver(
            new CustomMimeTypeResolver(['txt' => 'text/my-plain']),
            new ApacheMimeTypeResolver(),
        );

        assertSame($expected, $resolver->resolve($file));
    }
}
