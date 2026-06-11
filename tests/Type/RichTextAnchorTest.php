<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextAnchor;

use function PHPUnit\Framework\assertSame;

final class RichTextAnchorTest extends TestCase
{
    public function testBase(): void
    {
        $anchor = new RichTextAnchor('section1');

        assertSame('anchor', $anchor->getType());
        assertSame('section1', $anchor->name);
    }

    public function testFromTelegramResult(): void
    {
        $anchor = (new ObjectFactory())->create([
            'type' => 'anchor',
            'name' => 'section1',
        ], null, RichTextAnchor::class);

        assertSame('anchor', $anchor->getType());
        assertSame('section1', $anchor->name);
    }
}
