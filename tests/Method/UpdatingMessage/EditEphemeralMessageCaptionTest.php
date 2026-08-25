<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Constant\ParseMode;
use Phptg\BotApi\Method\UpdatingMessage\EditEphemeralMessageCaption;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditEphemeralMessageCaptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditEphemeralMessageCaption(23, 45, 34);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editEphemeralMessageCaption', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $messageEntity = new MessageEntity('bold', 0, 4);
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditEphemeralMessageCaption(
            23,
            45,
            34,
            'test',
            ParseMode::MARKDOWN_V2,
            [$messageEntity],
            $replyMarkup,
            true,
        );

        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
                'caption' => 'test',
                'parse_mode' => 'MarkdownV2',
                'caption_entities' => [$messageEntity->toRequestArray()],
                'show_caption_above_media' => true,
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditEphemeralMessageCaption(23, 45, 34);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        assertTrue($preparedResult);
    }
}
