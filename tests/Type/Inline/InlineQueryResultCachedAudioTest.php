<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultCachedAudio;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultCachedAudioTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedAudio(
            'id1',
            'audio_id1',
        );

        assertSame('audio', $type->getType());
        assertSame(
            [
                'type' => 'audio',
                'id' => 'id1',
                'audio_file_id' => 'audio_id1',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultCachedAudio(
            'id1',
            'audio_id1',
            'The caption',
            'HTML',
            [$entity],
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('audio', $type->getType());
        assertSame(
            [
                'type' => 'audio',
                'id' => 'id1',
                'audio_file_id' => 'audio_id1',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
