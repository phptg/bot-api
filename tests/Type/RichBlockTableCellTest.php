<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockTableCell;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RichBlockTableCellTest extends TestCase
{
    public function testBase(): void
    {
        $cell = new RichBlockTableCell('left', 'top');

        assertSame('left', $cell->align);
        assertSame('top', $cell->valign);
        assertNull($cell->text);
        assertNull($cell->isHeader);
        assertNull($cell->colspan);
        assertNull($cell->rowspan);
    }

    public function testFull(): void
    {
        $cell = new RichBlockTableCell('center', 'middle', 'hello', true, 2, 3);

        assertSame('center', $cell->align);
        assertSame('middle', $cell->valign);
        assertSame('hello', $cell->text);
        assertTrue($cell->isHeader);
        assertSame(2, $cell->colspan);
        assertSame(3, $cell->rowspan);
    }

    public function testFromTelegramResult(): void
    {
        $cell = (new ObjectFactory())->create([
            'align' => 'left',
            'valign' => 'top',
        ], null, RichBlockTableCell::class);

        assertSame('left', $cell->align);
        assertSame('top', $cell->valign);
        assertNull($cell->text);
        assertNull($cell->isHeader);
        assertNull($cell->colspan);
        assertNull($cell->rowspan);
    }

    public function testFromTelegramResultFull(): void
    {
        $cell = (new ObjectFactory())->create([
            'align' => 'center',
            'valign' => 'middle',
            'text' => ['type' => 'bold', 'text' => 'hello'],
            'is_header' => true,
            'colspan' => 2,
            'rowspan' => 3,
        ], null, RichBlockTableCell::class);

        assertSame('center', $cell->align);
        assertSame('middle', $cell->valign);
        assertInstanceOf(RichTextBold::class, $cell->text);
        assertSame('hello', $cell->text->text);
        assertTrue($cell->isHeader);
        assertSame(2, $cell->colspan);
        assertSame(3, $cell->rowspan);
    }
}
