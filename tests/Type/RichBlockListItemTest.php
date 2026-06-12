<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockListItem;
use Phptg\BotApi\Type\RichBlockParagraph;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RichBlockListItemTest extends TestCase
{
    public function testBase(): void
    {
        $item = new RichBlockListItem('1.', [new RichBlockParagraph('hello')]);

        assertSame('1.', $item->label);
        assertCount(1, $item->blocks);
        assertNull($item->hasCheckbox);
        assertNull($item->isChecked);
        assertNull($item->value);
        assertNull($item->type);
    }

    public function testFull(): void
    {
        $item = new RichBlockListItem('1.', [new RichBlockParagraph('hello')], true, true, 1, 'a');

        assertSame('1.', $item->label);
        assertTrue($item->hasCheckbox);
        assertTrue($item->isChecked);
        assertSame(1, $item->value);
        assertSame('a', $item->type);
    }

    public function testFromTelegramResult(): void
    {
        $item = (new ObjectFactory())->create([
            'label' => '1.',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
        ], null, RichBlockListItem::class);

        assertSame('1.', $item->label);
        assertCount(1, $item->blocks);
        assertInstanceOf(RichBlockParagraph::class, $item->blocks[0]);
        assertNull($item->hasCheckbox);
        assertNull($item->isChecked);
        assertNull($item->value);
        assertNull($item->type);
    }

    public function testFromTelegramResultFull(): void
    {
        $item = (new ObjectFactory())->create([
            'label' => '1.',
            'blocks' => [
                ['type' => 'paragraph', 'text' => 'hello'],
            ],
            'has_checkbox' => true,
            'is_checked' => true,
            'value' => 1,
            'type' => 'a',
        ], null, RichBlockListItem::class);

        assertSame('1.', $item->label);
        assertCount(1, $item->blocks);
        assertInstanceOf(RichBlockParagraph::class, $item->blocks[0]);
        assertTrue($item->hasCheckbox);
        assertTrue($item->isChecked);
        assertSame(1, $item->value);
        assertSame('a', $item->type);
    }
}
