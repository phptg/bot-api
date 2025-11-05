<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultGame;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultGameTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultGame(
            'id1',
            'the game',
        );

        assertSame('game', $type->getType());
        assertSame(
            [
                'type' => 'game',
                'id' => 'id1',
                'game_short_name' => 'the game',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultGame(
            'id1',
            'the game',
            $replyMarkup,
        );

        assertSame('game', $type->getType());
        assertSame(
            [
                'type' => 'game',
                'id' => 'id1',
                'game_short_name' => 'the game',
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
