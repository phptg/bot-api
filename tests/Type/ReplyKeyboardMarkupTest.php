<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\KeyboardButton;
use Phptg\BotApi\Type\ReplyKeyboardMarkup;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ReplyKeyboardMarkupTest extends TestCase
{
    public function testBase(): void
    {
        $button = new KeyboardButton('text');
        $markup = new ReplyKeyboardMarkup([[$button]]);

        assertSame([[$button]], $markup->keyboard);
        assertNull($markup->isPersistent);
        assertNull($markup->resizeKeyboard);
        assertNull($markup->oneTimeKeyboard);
        assertNull($markup->inputFieldPlaceholder);
        assertNull($markup->selective);

        assertSame(
            [
                'keyboard' => [[['text' => 'text']]],
            ],
            $markup->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $button = new KeyboardButton('text');
        $markup = new ReplyKeyboardMarkup([[$button]], true, false, true, 'test', true);

        assertSame([[$button]], $markup->keyboard);
        assertTrue($markup->isPersistent);
        assertFalse($markup->resizeKeyboard);
        assertTrue($markup->oneTimeKeyboard);
        assertSame('test', $markup->inputFieldPlaceholder);
        assertTrue($markup->selective);

        assertSame(
            [
                'keyboard' => [[['text' => 'text']]],
                'is_persistent' => true,
                'resize_keyboard' => false,
                'one_time_keyboard' => true,
                'input_field_placeholder' => 'test',
                'selective' => true,
            ],
            $markup->toRequestArray(),
        );
    }
}
