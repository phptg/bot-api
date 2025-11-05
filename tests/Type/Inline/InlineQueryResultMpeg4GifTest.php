<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultMpeg4Gif;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultMpeg4GifTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultMpeg4Gif(
            'id1',
            'https://example.com/test.mp4',
            'https://example.com/th.jpg',
        );

        assertSame('mpeg4_gif', $type->getType());
        assertSame(
            [
                'type' => 'mpeg4_gif',
                'id' => 'id1',
                'mpeg4_url' => 'https://example.com/test.mp4',
                'thumbnail_url' => 'https://example.com/th.jpg',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultMpeg4Gif(
            'id1',
            'https://example.com/test.mp4',
            'https://example.com/th.jpg',
            100,
            200,
            15,
            'image/jpeg',
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
                'mpeg4_url' => 'https://example.com/test.mp4',
                'mpeg4_width' => 100,
                'mpeg4_height' => 200,
                'mpeg4_duration' => 15,
                'thumbnail_url' => 'https://example.com/th.jpg',
                'thumbnail_mime_type' => 'image/jpeg',
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
