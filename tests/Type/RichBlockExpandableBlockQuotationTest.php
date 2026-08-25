<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockExpandableBlockQuotation;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockExpandableBlockQuotationTest extends TestCase
{
    public function testBase(): void
    {
        $blockquote = new RichBlockExpandableBlockQuotation('hello');

        assertSame('expandable_blockquote', $blockquote->getType());
        assertSame('hello', $blockquote->text);
        assertNull($blockquote->credit);
    }

    public function testFull(): void
    {
        $blockquote = new RichBlockExpandableBlockQuotation('hello', 'credit');

        assertSame('expandable_blockquote', $blockquote->getType());
        assertSame('hello', $blockquote->text);
        assertSame('credit', $blockquote->credit);
    }

    public function testFromTelegramResult(): void
    {
        $blockquote = (new ObjectFactory())->create([
            'type' => 'expandable_blockquote',
            'text' => 'hello',
        ], null, RichBlockExpandableBlockQuotation::class);

        assertSame('expandable_blockquote', $blockquote->getType());
        assertSame('hello', $blockquote->text);
        assertNull($blockquote->credit);
    }

    public function testFromTelegramResultFull(): void
    {
        $blockquote = (new ObjectFactory())->create([
            'type' => 'expandable_blockquote',
            'text' => ['type' => 'bold', 'text' => 'hello'],
            'credit' => ['type' => 'bold', 'text' => 'author'],
        ], null, RichBlockExpandableBlockQuotation::class);

        assertSame('expandable_blockquote', $blockquote->getType());
        assertInstanceOf(RichTextBold::class, $blockquote->text);
        assertSame('hello', $blockquote->text->text);
        assertInstanceOf(RichTextBold::class, $blockquote->credit);
        assertSame('author', $blockquote->credit->text);
    }
}
