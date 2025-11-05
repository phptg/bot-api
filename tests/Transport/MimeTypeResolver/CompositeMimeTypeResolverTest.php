<?php

declare(strict_types=1);

namespace Transport\MimeTypeResolver;

use HttpSoft\Message\Stream;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\CompositeMimeTypeResolver;
use Phptg\BotApi\Transport\MimeTypeResolver\CustomMimeTypeResolver;
use Phptg\BotApi\Type\InputFile;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class CompositeMimeTypeResolverTest extends TestCase
{
    public function testBase(): void
    {
        $resolver = new CompositeMimeTypeResolver(
            new CustomMimeTypeResolver(['txt' => 'text/my-plain']),
            new ApacheMimeTypeResolver(),
        );

        $fakeStream = new Stream();

        assertSame('text/my-plain', $resolver->resolve(new InputFile($fakeStream, 'test.txt')));
        assertSame('image/jpeg', $resolver->resolve(new InputFile($fakeStream, 'image.jpg')));
        assertNull($resolver->resolve(new InputFile($fakeStream, 'test.non-exist')));
    }
}
