<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultVideo;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultVideoTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultVideo(
            'id1',
            'https://example.com/test.mp4',
            'video/mp4',
            'https://example.com/th.jpg',
            'The title',
        );

        assertSame('video', $type->getType());
        assertSame(
            [
                'type' => 'video',
                'id' => 'id1',
                'video_url' => 'https://example.com/test.mp4',
                'mime_type' => 'video/mp4',
                'thumbnail_url' => 'https://example.com/th.jpg',
                'title' => 'The title',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultVideo(
            'id1',
            'https://example.com/test.mp4',
            'video/mp4',
            'https://example.com/th.jpg',
            'The title',
            'The caption',
            'HTML',
            [$entity],
            true,
            100,
            200,
            15,
            'The description',
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('video', $type->getType());
        assertSame(
            [
                'type' => 'video',
                'id' => 'id1',
                'video_url' => 'https://example.com/test.mp4',
                'mime_type' => 'video/mp4',
                'thumbnail_url' => 'https://example.com/th.jpg',
                'title' => 'The title',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'video_width' => 100,
                'video_height' => 200,
                'video_duration' => 15,
                'description' => 'The description',
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
