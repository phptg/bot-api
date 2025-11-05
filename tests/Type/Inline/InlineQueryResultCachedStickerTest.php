<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultCachedSticker;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultCachedStickerTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedSticker(
            'id1',
            'sticker_id1',
        );

        assertSame('sticker', $type->getType());
        assertSame(
            [
                'type' => 'sticker',
                'id' => 'id1',
                'sticker_file_id' => 'sticker_id1',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultCachedSticker(
            'id1',
            'sticker_id1',
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('sticker', $type->getType());
        assertSame(
            [
                'type' => 'sticker',
                'id' => 'id1',
                'sticker_file_id' => 'sticker_id1',
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
