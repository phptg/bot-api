<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultPhoto;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultPhoto(
            'id',
            'https://example.com/test.jpg',
            'https://example.com/th.jpg',
        );

        assertSame('photo', $type->getType());
        assertSame(
            [
                'type' => 'photo',
                'id' => 'id',
                'photo_url' => 'https://example.com/test.jpg',
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
        $type = new InlineQueryResultPhoto(
            'id1',
            'https://example.com/test.jpg',
            'https://example.com/th.jpg',
            100,
            200,
            'The title',
            'Any desc',
            'The caption',
            'HTML',
            [$entity],
            true,
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('photo', $type->getType());
        assertSame(
            [
                'type' => 'photo',
                'id' => 'id1',
                'photo_url' => 'https://example.com/test.jpg',
                'thumbnail_url' => 'https://example.com/th.jpg',
                'photo_width' => 100,
                'photo_height' => 200,
                'title' => 'The title',
                'description' => 'Any desc',
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
