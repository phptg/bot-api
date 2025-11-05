<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendLocation;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendLocationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendLocation(12, 1.1, 2.2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendLocation', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'latitude' => 1.1,
                'longitude' => 2.2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendLocation(
            12,
            1.1,
            2.2,
            'test',
            99,
            2.23,
            5,
            123,
            1,
            true,
            false,
            'id1',
            $replyParameters,
            $replyMarkup,
            true,
            123,
            new SuggestedPostParameters(
                new SuggestedPostPrice('USD', 10),
            ),
        );

        assertSame(
            [
                'business_connection_id' => 'test',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'direct_messages_topic_id' => 123,
                'latitude' => 1.1,
                'longitude' => 2.2,
                'horizontal_accuracy' => 2.23,
                'live_period' => 5,
                'heading' => 123,
                'proximity_alert_radius' => 1,
                'disable_notification' => true,
                'protect_content' => false,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'id1',
                'suggested_post_parameters' => [
                    'price' => [
                        'currency' => 'USD',
                        'amount' => 10,
                    ],
                ],
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendLocation(12, 1.1, 2.2);

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
