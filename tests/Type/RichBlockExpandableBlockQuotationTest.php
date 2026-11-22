<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockExpandableBlockQuotation;
use Phptg\BotApi\Type\RichBlockParagraph;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockExpandableBlockQuotationTest extends TestCase
{
    public function testBase(): void
    {
        $blockquote = new RichBlockExpandableBlockQuotation([new RichBlockParagraph('hello')]);

        assertSame('expandable_blockquote', $blockquote->getType());
        assertCount(1, $blockquote->blocks);
        assertNull($blockquote->credit);
    }

    public function testFull(): void
    {
        $blockquote = new RichBlockExpandableBlockQuotation(
            [new RichBlockParagraph('hello')],
            'credit',
        );

        assertSame('expandable_blockquote', $blockquote->getType());
        assertCount(1, $blockquote->blocks);
        assertSame('credit', $blockquote->credit);
    }

    public function testFromTelegramResult(): void
    {
        $blockquote = (new ObjectFactory())->create([
            'type' => 'expandable_blockquote',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
        ], null, RichBlockExpandableBlockQuotation::class);

        assertSame('expandable_blockquote', $blockquote->getType());
        assertCount(1, $blockquote->blocks);
        assertInstanceOf(RichBlockParagraph::class, $blockquote->blocks[0]);
        assertNull($blockquote->credit);
    }

    public function testFromTelegramResultFull(): void
    {
        $blockquote = (new ObjectFactory())->create([
            'type' => 'expandable_blockquote',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
            'credit' => ['type' => 'bold', 'text' => 'author'],
        ], null, RichBlockExpandableBlockQuotation::class);

        assertSame('expandable_blockquote', $blockquote->getType());
        assertCount(1, $blockquote->blocks);
        assertInstanceOf(RichBlockParagraph::class, $blockquote->blocks[0]);
        assertSame('hello', $blockquote->blocks[0]->text);
        assertInstanceOf(RichTextBold::class, $blockquote->credit);
        assertSame('author', $blockquote->credit->text);
    }
}
