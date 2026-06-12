<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockCollage;
use Phptg\BotApi\Type\RichBlockParagraph;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockCollageTest extends TestCase
{
    public function testBase(): void
    {
        $collage = new RichBlockCollage([new RichBlockParagraph('hello')]);

        assertSame('collage', $collage->getType());
        assertCount(1, $collage->blocks);
        assertNull($collage->caption);
    }

    public function testFull(): void
    {
        $caption = new RichBlockCaption('caption text');
        $collage = new RichBlockCollage([new RichBlockParagraph('hello')], $caption);

        assertSame('collage', $collage->getType());
        assertCount(1, $collage->blocks);
        assertSame($caption, $collage->caption);
    }

    public function testFromTelegramResult(): void
    {
        $collage = (new ObjectFactory())->create([
            'type' => 'collage',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
        ], null, RichBlockCollage::class);

        assertSame('collage', $collage->getType());
        assertCount(1, $collage->blocks);
        assertInstanceOf(RichBlockParagraph::class, $collage->blocks[0]);
        assertNull($collage->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $collage = (new ObjectFactory())->create([
            'type' => 'collage',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
            'caption' => ['text' => 'caption text'],
        ], null, RichBlockCollage::class);

        assertSame('collage', $collage->getType());
        assertCount(1, $collage->blocks);
        assertInstanceOf(RichBlockParagraph::class, $collage->blocks[0]);
        assertInstanceOf(RichBlockCaption::class, $collage->caption);
    }
}
