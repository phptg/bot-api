<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockList;
use Phptg\BotApi\Type\RichBlockListItem;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class RichBlockListTest extends TestCase
{
    public function testBase(): void
    {
        $list = new RichBlockList([new RichBlockListItem('1.', [])]);

        assertSame('list', $list->getType());
        assertCount(1, $list->items);
    }

    public function testFromTelegramResult(): void
    {
        $list = (new ObjectFactory())->create([
            'type' => 'list',
            'items' => [
                ['label' => '1.', 'blocks' => []],
                ['label' => '2.', 'blocks' => []],
            ],
        ], null, RichBlockList::class);

        assertSame('list', $list->getType());
        assertCount(2, $list->items);
        assertInstanceOf(RichBlockListItem::class, $list->items[0]);
        assertSame('1.', $list->items[0]->label);
        assertSame('2.', $list->items[1]->label);
    }
}
