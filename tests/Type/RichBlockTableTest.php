<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockTable;
use Phptg\BotApi\Type\RichBlockTableCell;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RichBlockTableTest extends TestCase
{
    public function testBase(): void
    {
        $cell = new RichBlockTableCell('left', 'top');
        $table = new RichBlockTable([[$cell]]);

        assertSame('table', $table->getType());
        assertCount(1, $table->cells);
        assertCount(1, $table->cells[0]);
        assertSame('left', $table->cells[0][0]->align);
        assertSame('top', $table->cells[0][0]->valign);
        assertNull($table->isBordered);
        assertNull($table->isStriped);
        assertNull($table->caption);
    }

    public function testFull(): void
    {
        $cell = new RichBlockTableCell('center', 'middle');
        $table = new RichBlockTable([[$cell]], true, true, 'caption');

        assertSame('table', $table->getType());
        assertCount(1, $table->cells);
        assertCount(1, $table->cells[0]);
        assertSame('center', $table->cells[0][0]->align);
        assertSame('middle', $table->cells[0][0]->valign);
        assertTrue($table->isBordered);
        assertTrue($table->isStriped);
        assertSame('caption', $table->caption);
    }

    public function testFromTelegramResult(): void
    {
        $table = (new ObjectFactory())->create([
            'type' => 'table',
            'cells' => [
                [
                    ['align' => 'left', 'valign' => 'top'],
                ],
            ],
        ], null, RichBlockTable::class);

        assertSame('table', $table->getType());
        assertCount(1, $table->cells);
        assertCount(1, $table->cells[0]);
        assertInstanceOf(RichBlockTableCell::class, $table->cells[0][0]);
        assertSame('left', $table->cells[0][0]->align);
        assertSame('top', $table->cells[0][0]->valign);
        assertNull($table->isBordered);
        assertNull($table->isStriped);
        assertNull($table->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $table = (new ObjectFactory())->create([
            'type' => 'table',
            'cells' => [
                [
                    ['align' => 'center', 'valign' => 'middle'],
                ],
            ],
            'is_bordered' => true,
            'is_striped' => true,
            'caption' => ['type' => 'bold', 'text' => 'caption'],
        ], null, RichBlockTable::class);

        assertSame('table', $table->getType());
        assertCount(1, $table->cells);
        assertCount(1, $table->cells[0]);
        assertInstanceOf(RichBlockTableCell::class, $table->cells[0][0]);
        assertSame('center', $table->cells[0][0]->align);
        assertSame('middle', $table->cells[0][0]->valign);
        assertTrue($table->isBordered);
        assertTrue($table->isStriped);
        assertInstanceOf(RichTextBold::class, $table->caption);
        assertSame('caption', $table->caption->text);
    }
}
