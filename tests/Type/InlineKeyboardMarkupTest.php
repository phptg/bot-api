<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class InlineKeyboardMarkupTest extends TestCase
{
    public function testBase(): void
    {
        $button = new InlineKeyboardButton('test');
        $markup = new InlineKeyboardMarkup([
            [$button],
        ]);

        assertSame([[$button]], $markup->inlineKeyboard);

        assertSame(
            [
                'inline_keyboard' => [
                    [
                        $button->toRequestArray(),
                    ],
                ],
            ],
            $markup->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $markup = (new ObjectFactory())->create([
            'inline_keyboard' => [
                [
                    [
                        'text' => 'test',
                    ],
                ],
            ],
        ], null, InlineKeyboardMarkup::class);

        assertCount(1, $markup->inlineKeyboard);
        assertCount(1, $markup->inlineKeyboard[0]);
        assertInstanceOf(InlineKeyboardButton::class, $markup->inlineKeyboard[0][0]);
        assertSame('test', $markup->inlineKeyboard[0][0]->text);
    }
}
