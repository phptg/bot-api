<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Constant\ParseMode;
use Phptg\BotApi\Method\UpdatingMessage\EditEphemeralMessageText;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\InputRichMessage;
use Phptg\BotApi\Type\LinkPreviewOptions;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditEphemeralMessageTextTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditEphemeralMessageText(23, 45, 34, 'hello');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editEphemeralMessageText', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
                'text' => 'hello',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $messageEntity = new MessageEntity('bold', 0, 4);
        $linkPreviewOptions = new LinkPreviewOptions(true);
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditEphemeralMessageText(
            23,
            45,
            34,
            'hello',
            ParseMode::MARKDOWN_V2,
            [$messageEntity],
            $linkPreviewOptions,
            $replyMarkup,
            new InputRichMessage(html: '<b>hello</b>'),
        );

        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
                'text' => 'hello',
                'parse_mode' => 'MarkdownV2',
                'entities' => [$messageEntity->toRequestArray()],
                'rich_message' => ['html' => '<b>hello</b>'],
                'link_preview_options' => $linkPreviewOptions->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditEphemeralMessageText(23, 45, 34, 'hello');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        assertTrue($preparedResult);
    }
}
