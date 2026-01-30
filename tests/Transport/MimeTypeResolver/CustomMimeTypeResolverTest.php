<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Transport\MimeTypeResolver;

use HttpSoft\Message\Stream;
use Phptg\BotApi\Transport\InputFileData;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\MimeTypeResolver\CustomMimeTypeResolver;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertSame;

final class CustomMimeTypeResolverTest extends TestCase
{
    public static function dataBase(): iterable
    {
        yield [null, new InputFile(new Stream())];
        yield [null, new InputFile(new Stream(), 'test.non-exist-extension')];
        yield ['image/jpeg', new InputFile(new Stream(), 'test.jpg')];
        yield ['image/jpeg', new InputFile(new Stream(), 'TEST.JPG')];
        yield ['text/plain', InputFile::fromLocalFile(__DIR__ . '/files/test.txt')];
        yield ['text/css', InputFile::fromLocalFile(__DIR__ . '/files/test.txt', 'test.css')];
    }

    #[DataProvider('dataBase')]
    public function testBase(?string $expected, InputFile $file): void
    {
        $resolver = new CustomMimeTypeResolver([
            'jpg' => 'image/jpeg',
            'txt' => 'text/plain',
            'css' => 'text/css',
        ]);

        $result = $resolver->resolve(new InputFileData($file));

        assertSame($expected, $result);
    }
}
