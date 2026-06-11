<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockSlideshow;
use Phptg\BotApi\Type\RichBlockParagraph;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockSlideshowTest extends TestCase
{
    public function testBase(): void
    {
        $slideshow = new RichBlockSlideshow([new RichBlockParagraph('hello')]);

        assertSame('slideshow', $slideshow->getType());
        assertCount(1, $slideshow->blocks);
        assertNull($slideshow->caption);
    }

    public function testFull(): void
    {
        $caption = new RichBlockCaption('caption text');
        $slideshow = new RichBlockSlideshow([new RichBlockParagraph('hello')], $caption);

        assertSame('slideshow', $slideshow->getType());
        assertCount(1, $slideshow->blocks);
        assertSame($caption, $slideshow->caption);
    }

    public function testFromTelegramResult(): void
    {
        $slideshow = (new ObjectFactory())->create([
            'type' => 'slideshow',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
        ], null, RichBlockSlideshow::class);

        assertSame('slideshow', $slideshow->getType());
        assertCount(1, $slideshow->blocks);
        assertInstanceOf(RichBlockParagraph::class, $slideshow->blocks[0]);
        assertNull($slideshow->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $slideshow = (new ObjectFactory())->create([
            'type' => 'slideshow',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
            'caption' => ['text' => 'caption text'],
        ], null, RichBlockSlideshow::class);

        assertSame('slideshow', $slideshow->getType());
        assertCount(1, $slideshow->blocks);
        assertInstanceOf(RichBlockParagraph::class, $slideshow->blocks[0]);
        assertInstanceOf(RichBlockCaption::class, $slideshow->caption);
    }
}
