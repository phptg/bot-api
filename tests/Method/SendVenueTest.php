<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendVenue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendVenueTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendVenue(12, 1.1, 2.2, 'Moscow', 'Kremlin');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendVenue', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'latitude' => 1.1,
                'longitude' => 2.2,
                'title' => 'Moscow',
                'address' => 'Kremlin',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendVenue(
            12,
            1.1,
            2.2,
            'Moscow',
            'Kremlin',
            'bcid1',
            99,
            'fs1',
            'ft2',
            'gp1',
            'gt2',
            true,
            false,
            'meid1',
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
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'direct_messages_topic_id' => 123,
                'latitude' => 1.1,
                'longitude' => 2.2,
                'title' => 'Moscow',
                'address' => 'Kremlin',
                'foursquare_id' => 'fs1',
                'foursquare_type' => 'ft2',
                'google_place_id' => 'gp1',
                'google_place_type' => 'gt2',
                'disable_notification' => true,
                'protect_content' => false,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meid1',
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
        $method = new SendVenue(12, 1.1, 2.2, 'Moscow', 'Kremlin');

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
