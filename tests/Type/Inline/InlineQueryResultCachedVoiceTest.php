<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InlineQueryResultCachedVoice;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultCachedVoiceTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedVoice(
            'id1',
            'voice_id1',
            'The title',
        );

        assertSame('voice', $type->getType());
        assertSame(
            [
                'type' => 'voice',
                'id' => 'id1',
                'voice_file_id' => 'voice_id1',
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
        $type = new InlineQueryResultCachedVoice(
            'id1',
            'voice_id1',
            'The title',
            'The caption',
            'HTML',
            [$entity],
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('voice', $type->getType());
        assertSame(
            [
                'type' => 'voice',
                'id' => 'id1',
                'voice_file_id' => 'voice_id1',
                'title' => 'The title',
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
