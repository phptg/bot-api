<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\LinkPreviewOptions;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendMessage(12, 'hello');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendMessage', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'text' => 'hello',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 5);
        $linkPreviewOptions = new LinkPreviewOptions(true);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendMessage(
            12,
            'hello',
            'bcid1',
            99,
            'parse',
            [$entity],
            $linkPreviewOptions,
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
                'text' => 'hello',
                'parse_mode' => 'parse',
                'entities' => [$entity->toRequestArray()],
                'link_preview_options' => $linkPreviewOptions->toRequestArray(),
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
        $method = new SendMessage(12, 'hello');

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
