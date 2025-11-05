<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\CopyMessage;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class CopyMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CopyMessage(1, 2, 3);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('copyMessage', $method->getApiMethod());
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
        $messageEntity = new MessageEntity('bold', 0, 4);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new CopyMessage(
            1,
            2,
            3,
            4,
            'test',
            'MarkdownV2',
            [$messageEntity],
            true,
            false,
            true,
            $replyParameters,
            $replyMarkup,
            true,
            17,
            123,
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
                'message_id' => 3,
                'video_start_timestamp' => 17,
                'caption' => 'test',
                'parse_mode' => 'MarkdownV2',
                'caption_entities' => [$messageEntity->toRequestArray()],
                'show_caption_above_media' => true,
                'disable_notification' => false,
                'protect_content' => true,
                'allow_paid_broadcast' => true,
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
        $method = new CopyMessage(1, 2, 3);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
        ])->call($method);

        assertSame(7, $preparedResult->messageId);
    }
}
