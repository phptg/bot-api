<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockButtons;
use Phptg\BotApi\Type\RichMessageButton;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockButtonsTest extends TestCase
{
    public function testBase(): void
    {
        $block = new InputRichBlockButtons([new RichMessageButton('test', callbackData: 'data')]);

        assertSame('buttons', $block->getType());
        assertSame(
            [
                'type' => 'buttons',
                'buttons' => [
                    ['text' => 'test', 'callback_data' => 'data'],
                ],
            ],
            $block->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $block = new InputRichBlockButtons(
            [new RichMessageButton('test', callbackData: 'data')],
            'left',
        );

        assertSame(
            [
                'type' => 'buttons',
                'buttons' => [
                    ['text' => 'test', 'callback_data' => 'data'],
                ],
                'align' => 'left',
            ],
            $block->toRequestArray(),
        );
    }
}
