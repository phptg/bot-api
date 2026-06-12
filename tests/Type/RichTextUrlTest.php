<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextUrl;

use function PHPUnit\Framework\assertSame;

final class RichTextUrlTest extends TestCase
{
    public function testBase(): void
    {
        $url = new RichTextUrl('hello', 'https://example.com');

        assertSame('url', $url->getType());
        assertSame('hello', $url->text);
        assertSame('https://example.com', $url->url);
    }

    public function testFromTelegramResult(): void
    {
        $url = (new ObjectFactory())->create([
            'type' => 'url',
            'text' => 'hello',
            'url' => 'https://example.com',
        ], null, RichTextUrl::class);

        assertSame('url', $url->getType());
        assertSame('hello', $url->text);
        assertSame('https://example.com', $url->url);
    }
}
