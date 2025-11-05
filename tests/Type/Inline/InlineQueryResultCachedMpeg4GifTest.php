<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultCachedMpeg4Gif;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultCachedMpeg4GifTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedMpeg4Gif(
            'id1',
            'mpeg4_gif_id1',
        );

        assertSame('mpeg4_gif', $type->getType());
        assertSame(
            [
                'type' => 'mpeg4_gif',
                'id' => 'id1',
                'mpeg4_file_id' => 'mpeg4_gif_id1',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultCachedMpeg4Gif(
            'id1',
            'mpeg4_gif_id1',
            'The title',
            'The caption',
            'HTML',
            [$entity],
            true,
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('mpeg4_gif', $type->getType());
        assertSame(
            [
                'type' => 'mpeg4_gif',
                'id' => 'id1',
                'mpeg4_file_id' => 'mpeg4_gif_id1',
                'title' => 'The title',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
