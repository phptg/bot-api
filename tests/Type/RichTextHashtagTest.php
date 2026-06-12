<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextHashtag;

use function PHPUnit\Framework\assertSame;

final class RichTextHashtagTest extends TestCase
{
    public function testBase(): void
    {
        $hashtag = new RichTextHashtag('hello', '#world');

        assertSame('hashtag', $hashtag->getType());
        assertSame('hello', $hashtag->text);
        assertSame('#world', $hashtag->hashtag);
    }

    public function testFromTelegramResult(): void
    {
        $hashtag = (new ObjectFactory())->create([
            'type' => 'hashtag',
            'text' => 'hello',
            'hashtag' => '#world',
        ], null, RichTextHashtag::class);

        assertSame('hashtag', $hashtag->getType());
        assertSame('hello', $hashtag->text);
        assertSame('#world', $hashtag->hashtag);
    }
}
