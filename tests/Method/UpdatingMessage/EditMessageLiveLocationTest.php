<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UpdatingMessage\EditMessageLiveLocation;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\Message;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditMessageLiveLocationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditMessageLiveLocation(51.660781, 39.200296);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editMessageLiveLocation', $method->getApiMethod());
        assertSame(
            [
                'latitude' => 51.660781,
                'longitude' => 39.200296,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditMessageLiveLocation(
            51.660781,
            39.200296,
            'bcid1',
            23,
            34,
            'imid',
            1000,
            20.5,
            220,
            500,
            $replyMarkup,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 23,
                'message_id' => 34,
                'inline_message_id' => 'imid',
                'latitude' => 51.660781,
                'longitude' => 39.200296,
                'live_period' => 1000,
                'horizontal_accuracy' => 20.5,
                'heading' => 220,
                'proximity_alert_radius' => 500,
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditMessageLiveLocation(51.660781, 39.200296);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        assertTrue($preparedResult);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);
        assertInstanceOf(Message::class, $preparedResult);
        assertSame(7, $preparedResult->messageId);
    }
}
