<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultCachedPhoto;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultCachedPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedPhoto(
            'id1',
            'photo_id1',
        );

        assertSame('photo', $type->getType());
        assertSame(
            [
                'type' => 'photo',
                'id' => 'id1',
                'photo_file_id' => 'photo_id1',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultCachedPhoto(
            'id1',
            'photo_id1',
            'The title',
            'The description',
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
                'photo_file_id' => 'photo_id1',
                'title' => 'The title',
                'description' => 'The description',
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
