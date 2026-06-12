<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextAnchorLink;

use function PHPUnit\Framework\assertSame;

final class RichTextAnchorLinkTest extends TestCase
{
    public function testBase(): void
    {
        $anchorLink = new RichTextAnchorLink('hello', 'section1');

        assertSame('anchor_link', $anchorLink->getType());
        assertSame('hello', $anchorLink->text);
        assertSame('section1', $anchorLink->anchorName);
    }

    public function testFromTelegramResult(): void
    {
        $anchorLink = (new ObjectFactory())->create([
            'type' => 'anchor_link',
            'text' => 'hello',
            'anchor_name' => 'section1',
        ], null, RichTextAnchorLink::class);

        assertSame('anchor_link', $anchorLink->getType());
        assertSame('hello', $anchorLink->text);
        assertSame('section1', $anchorLink->anchorName);
    }

    public function testEmptyAnchorName(): void
    {
        $anchorLink = (new ObjectFactory())->create([
            'type' => 'anchor_link',
            'text' => 'back to top',
            'anchor_name' => '',
        ], null, RichTextAnchorLink::class);

        assertSame('', $anchorLink->anchorName);
    }
}
