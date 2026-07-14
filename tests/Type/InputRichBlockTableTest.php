<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockTable;
use Phptg\BotApi\Type\RichBlockTableCell;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockTableTest extends TestCase
{
    public function testBase(): void
    {
        $cell = new RichBlockTableCell('left', 'top', 'hello');
        $table = new InputRichBlockTable([[$cell]]);

        assertSame('table', $table->getType());
        assertSame(
            ['type' => 'table', 'cells' => [[['align' => 'left', 'valign' => 'top', 'text' => 'hello']]]],
            $table->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $cell = new RichBlockTableCell('left', 'top', 'hello');
        $table = new InputRichBlockTable([[$cell]], true, true, 'caption');

        assertSame(
            [
                'type' => 'table',
                'cells' => [[['align' => 'left', 'valign' => 'top', 'text' => 'hello']]],
                'is_bordered' => true,
                'is_striped' => true,
                'caption' => 'caption',
            ],
            $table->toRequestArray(),
        );
    }
}
