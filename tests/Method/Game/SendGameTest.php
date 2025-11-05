<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Game;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Game\SendGame;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\ReplyParameters;

use function PHPUnit\Framework\assertSame;

final class SendGameTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendGame(12, 'Racing');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendGame', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'game_short_name' => 'Racing',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $method = new SendGame(
            12,
            'Racing',
            'bcid1',
            99,
            false,
            true,
            'meid',
            $replyParameters,
            $replyMarkup,
            true,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'game_short_name' => 'Racing',
                'disable_notification' => false,
                'protect_content' => true,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meid',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendGame(12, 'Racing');

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);

        assertSame(7, $preparedResult->messageId);
    }
}
