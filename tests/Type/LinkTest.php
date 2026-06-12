<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Link;

use function PHPUnit\Framework\assertSame;

final class LinkTest extends TestCase
{
    public function testBase(): void
    {
        $link = new Link('https://example.com');

        assertSame('https://example.com', $link->url);
    }

    public function testFromTelegramResult(): void
    {
        $link = (new ObjectFactory())->create([
            'url' => 'https://example.com',
        ], null, Link::class);

        assertSame('https://example.com', $link->url);
    }
}
