<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UpdatingMessage\EditEphemeralMessageReplyMarkup;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditEphemeralMessageReplyMarkupTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditEphemeralMessageReplyMarkup(23, 45, 34);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editEphemeralMessageReplyMarkup', $method->getApiMethod());
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
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditEphemeralMessageReplyMarkup(23, 45, 34, $replyMarkup);

        assertSame(
            [
                'chat_id' => 23,
                'receiver_user_id' => 45,
                'ephemeral_message_id' => 34,
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditEphemeralMessageReplyMarkup(23, 45, 34);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        assertTrue($preparedResult);
    }
}
