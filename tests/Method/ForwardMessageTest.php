<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\ForwardMessage;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class ForwardMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ForwardMessage(1, 2, 3);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('forwardMessage', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'from_chat_id' => 2,
                'message_id' => 3,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new ForwardMessage(
            1,
            2,
            3,
            4,
            true,
            false,
            17,
            123,
            'effect_123',
            new SuggestedPostParameters(
                new SuggestedPostPrice('USD', 10),
            ),
        );

        assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 4,
                'direct_messages_topic_id' => 123,
                'from_chat_id' => 2,
                'video_start_timestamp' => 17,
                'disable_notification' => true,
                'protect_content' => false,
                'message_effect_id' => 'effect_123',
                'suggested_post_parameters' => [
                    'price' => [
                        'currency' => 'USD',
                        'amount' => 10,
                    ],
                ],
                'message_id' => 3,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ForwardMessage(1, 2, 3);

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
