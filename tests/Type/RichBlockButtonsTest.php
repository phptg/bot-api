<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockButtons;
use Phptg\BotApi\Type\RichMessageButton;

use function PHPUnit\Framework\assertContainsOnlyInstancesOf;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockButtonsTest extends TestCase
{
    public function testBase(): void
    {
        $button = new RichMessageButton('test');
        $block = new RichBlockButtons([$button]);

        assertSame('buttons', $block->getType());
        assertSame([$button], $block->buttons);
        assertNull($block->align);
    }

    public function testFull(): void
    {
        $button = new RichMessageButton('test');
        $block = new RichBlockButtons([$button], 'center');

        assertSame('buttons', $block->getType());
        assertSame([$button], $block->buttons);
        assertSame('center', $block->align);
    }

    public function testFromTelegramResult(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'buttons',
            'buttons' => [
                ['text' => 'test'],
            ],
        ], null, RichBlockButtons::class);

        assertSame('buttons', $block->getType());
        assertCount(1, $block->buttons);
        assertContainsOnlyInstancesOf(RichMessageButton::class, $block->buttons);
        assertSame('test', $block->buttons[0]->text);
        assertNull($block->align);
    }

    public function testFromTelegramResultFull(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'buttons',
            'buttons' => [
                ['text' => 'test'],
            ],
            'align' => 'right',
        ], null, RichBlockButtons::class);

        assertSame('buttons', $block->getType());
        assertCount(1, $block->buttons);
        assertContainsOnlyInstancesOf(RichMessageButton::class, $block->buttons);
        assertSame('right', $block->align);
    }
}
