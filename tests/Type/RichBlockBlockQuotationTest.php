<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockBlockQuotation;
use Phptg\BotApi\Type\RichBlockParagraph;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockBlockQuotationTest extends TestCase
{
    public function testBase(): void
    {
        $blockquote = new RichBlockBlockQuotation([new RichBlockParagraph('hello')]);

        assertSame('blockquote', $blockquote->getType());
        assertCount(1, $blockquote->blocks);
        assertNull($blockquote->credit);
    }

    public function testFull(): void
    {
        $blockquote = new RichBlockBlockQuotation([new RichBlockParagraph('hello')], 'credit');

        assertSame('blockquote', $blockquote->getType());
        assertCount(1, $blockquote->blocks);
        assertSame('credit', $blockquote->credit);
    }

    public function testFromTelegramResult(): void
    {
        $blockquote = (new ObjectFactory())->create([
            'type' => 'blockquote',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
        ], null, RichBlockBlockQuotation::class);

        assertSame('blockquote', $blockquote->getType());
        assertCount(1, $blockquote->blocks);
        assertInstanceOf(RichBlockParagraph::class, $blockquote->blocks[0]);
        assertNull($blockquote->credit);
    }

    public function testFromTelegramResultFull(): void
    {
        $blockquote = (new ObjectFactory())->create([
            'type' => 'blockquote',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
            'credit' => ['type' => 'bold', 'text' => 'author'],
        ], null, RichBlockBlockQuotation::class);

        assertSame('blockquote', $blockquote->getType());
        assertCount(1, $blockquote->blocks);
        assertInstanceOf(RichBlockParagraph::class, $blockquote->blocks[0]);
        assertInstanceOf(RichTextBold::class, $blockquote->credit);
        assertSame('author', $blockquote->credit->text);
    }
}
