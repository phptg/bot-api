<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendRichMessage;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\ForceReply;
use Phptg\BotApi\Type\InputRichMessage;
use Phptg\BotApi\Type\ReplyParameters;
use Phptg\BotApi\Type\SuggestedPostParameters;
use Phptg\BotApi\Type\SuggestedPostPrice;

use function PHPUnit\Framework\assertSame;

final class SendRichMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendRichMessage(12, new InputRichMessage(html: '<b>Hello</b>'));

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendRichMessage', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 12,
                'rich_message' => ['html' => '<b>Hello</b>'],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $richMessage = new InputRichMessage(html: '<b>Hello</b>', isRtl: true);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $suggestedPostParameters = new SuggestedPostParameters(new SuggestedPostPrice('USD', 10));
        $method = new SendRichMessage(
            12,
            $richMessage,
            'bcid1',
            99,
            123,
            true,
            false,
            true,
            'meid1',
            $suggestedPostParameters,
            $replyParameters,
            $replyMarkup,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'direct_messages_topic_id' => 123,
                'rich_message' => ['html' => '<b>Hello</b>', 'is_rtl' => true],
                'disable_notification' => true,
                'protect_content' => false,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meid1',
                'suggested_post_parameters' => $suggestedPostParameters->toRequestArray(),
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendRichMessage(12, new InputRichMessage(html: '<b>Hello</b>'));

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
